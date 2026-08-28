<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ojt extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila'); // Sets exact PH Time for all time calculations
        $this->load->model('Ojt_model');
    }

    public function index($username = NULL) {
    // FIX: Prevents index from intercepting action controller routes!
    $reserved_actions = array('time_in', 'time_out', 'update_target_hours', 'email', 'profile', 'update_email', 'update_password', 'update_info', 'analytics', 'logs', 'export_pdf', 'analytics_partial', 'logs_partial', 'request_deletion', 'delete_log');
    if (in_array(strtolower($username), $reserved_actions)) {
        $method = strtolower($username);
        $this->$method();
        return;
    }
    // 0. If someone hits /ojt/email directly, redirect back to main OJT page
    if (strtolower($username) === 'email') {
        redirect('ojt');
        return;
    }

    $reserved_actions = array('time_in', 'time_out', 'update_target_hours', 'update_email');
    if (in_array(strtolower($username), $reserved_actions)) {
        $method = strtolower($username);
        $this->$method();
        return;
    }

    // 1. Get logged in user data from session
    $session_user_id    = $this->session->userdata('user_id');
    $session_first_name = $this->session->userdata('first_name');
    $session_username   = $this->session->userdata('username');

    // 2. Determine raw slug priority: first_name -> username -> fallback 'user'
    $raw_slug = !empty($session_first_name) ? $session_first_name : (!empty($session_username) ? $session_username : 'user');

    // Clean slug: remove email domain/special chars to prevent URI character errors
    $clean_slug = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', explode('@', $raw_slug)[0]));

    // 3. Handle URL Redirection if no slug is present in URL
    if (empty($username)) {
        redirect('ojt/' . $clean_slug);
        return;
    }

    // 4. Resolve target user details from database (matches username OR first_name)
    $this->db->group_start();
    $this->db->where('username', $username);
    $this->db->or_where('first_name', $username);
    $this->db->group_end();
    $user = $this->db->get('users')->row_array();

    if (!empty($user)) {
        $user_id = $user['id'];
    } else {
        // Fallback to active session user_id or default to 1
        $user_id = !empty($session_user_id) ? $session_user_id : 1;
    }

    // 5. Fetch target hours from user_profile (Default: 500)
    $profile = $this->db->get_where('user_profile', array('id' => $user_id))->row_array();
    $required_hours = (!empty($profile) && !empty($profile['required_hours'])) ? (float)$profile['required_hours'] : 500;

    // 6. Compute total rendered hours from database
    $this->db->select_sum('hours_rendered');
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('ojt_logs')->row_array();
    $rendered_hours = !empty($query['hours_rendered']) ? (float)$query['hours_rendered'] : 0.00;

    // 7. Compute remaining hours and percentage progress
    $remaining_hours = max(0, $required_hours - $rendered_hours);
    $progress_pct = ($required_hours > 0) ? min(100, round(($rendered_hours / $required_hours) * 100, 1)) : 0;

    // 8. FIX: Fetch active attendance log (where time_out is NULL or status matches running)
    $this->db->where('user_id', $user_id);
    $this->db->group_start();
    $this->db->where('time_out IS NULL', NULL, FALSE);
    $this->db->or_where('status', 'Running...');
    $this->db->group_end();
    $active_log = $this->db->get('ojt_logs')->row_array();

    // 9. Fetch all time logs for DTR table
    $this->db->where('user_id', $user_id);
    $this->db->order_by('id', 'DESC');
    $logs = $this->db->get('ojt_logs')->result_array();

    // 10. Pass variables to view
    $data = array(
        'page_title'       => 'OJT Hours Tracker',
        'current_username' => $username,
        'required_hours'   => $required_hours,
        'rendered_hours'   => $rendered_hours,
        'remaining_hours'  => $remaining_hours,
        'progress_pct'     => $progress_pct,
        'active_log'       => $active_log,
        'logs'             => $logs
    );

    $this->load->view('ojt_tracker', $data);
}

    // --- REAL-TIME ATTENDANCE METHODS ---

    public function time_in() {
    $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

    // Check kung may nakabinbing active shift
    $active = $this->db->get_where('ojt_logs', array('user_id' => $user_id, 'status' => 'active'))->row();

    if (!$active) {
        $logData = array(
            'user_id'        => $user_id,
            'log_date'       => date('Y-m-d'),
            'time_in'        => date('Y-m-d H:i:s'),
            'time_out'       => NULL,
            'hours_rendered' => 0.00,
            'status'         => 'active'
        );

        $this->db->insert('ojt_logs', $logData);
    }

    redirect('ojt');
}

public function time_out() {
    $user_id = $this->session->userdata('user_id');

    // 1. Session check: redirect to login if session has expired or is missing
    if (empty($user_id)) {
        redirect('auth/login');
        return;
    }

    // 2. Query active log: match user AND find record where time_out is NULL or status is 'Running...'
    $this->db->where('user_id', $user_id);
    $this->db->group_start();
    $this->db->where('time_out IS NULL', NULL, FALSE);
    $this->db->or_where('status', 'Running...');
    $this->db->group_end();
    
    $active_log = $this->db->get('ojt_logs')->row_array();

    // 3. Fallback: search for any open log for this user if status string was modified
    if (empty($active_log)) {
        $active_log = $this->db->where('user_id', $user_id)
                               ->where('time_out IS NULL', NULL, FALSE)
                               ->order_by('id', 'DESC')
                               ->get('ojt_logs')
                               ->row_array();
    }

    // 4. Update the record and calculate hours
    if (!empty($active_log)) {
        $time_in  = new DateTime($active_log['time_in']);
        $time_out = new DateTime();
        $interval = $time_in->diff($time_out);

        // Compute total decimal hours (including multi-day intervals)
        $hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);
        
        // Subtract 1-hour break for shifts of 5 hours or more
        if ($hours >= 5) { 
            $hours -= 1; 
        }

        $update_data = array(
            'time_out'       => $time_out->format('Y-m-d H:i:s'),
            'hours_rendered' => max(0, round($hours, 2)),
            'status'         => 'Approved'
        );

        $this->db->where('id', $active_log['id']);
        $this->db->update('ojt_logs', $update_data);
        $this->session->set_flashdata('success', 'Timed out successfully!');
    }

    // 5. Redirect back to the OJT dashboard
    redirect('ojt');
}
    // --- MANUAL ENTRY & EDITING METHODS ---

    public function add_log() {
        $this->form_validation->set_rules('log_date', 'Date', 'required');
        $this->form_validation->set_rules('time_in', 'Time In', 'required');
        $this->form_validation->set_rules('time_out', 'Time Out', 'required');
        $this->form_validation->set_rules('task_summary', 'Tasks Done', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;
            $time_in  = new DateTime($this->input->post('time_in'));
            $time_out = new DateTime($this->input->post('time_out'));
            $interval = $time_in->diff($time_out);
            
            $hours = $interval->h + ($interval->i / 60);
            if ($hours >= 5) { $hours -= 1; }

            $logData = array(
                'user_id'        => $user_id,
                'log_date'       => $this->input->post('log_date'),
                'time_in'        => $this->input->post('time_in'),
                'time_out'       => $this->input->post('time_out'),
                'hours_rendered' => max(0, $hours),
                'task_summary'   => trim($this->input->post('task_summary', TRUE)),
                'status'         => 'Approved'
            );

            $this->Ojt_model->insert_log($logData);
            $this->session->set_flashdata('success', 'Time log recorded successfully!');
        }

        redirect('ojt');
    }

    public function update_log($id) {
        $task_summary = $this->input->post('task_summary', TRUE);

        if (!empty($task_summary) && is_numeric($id)) {
            $logData = array(
                'task_summary' => trim($task_summary)
            );

            // Optional full dateTime update if post variables exist
            if ($this->input->post('time_in') && $this->input->post('time_out')) {
                $time_in  = new DateTime($this->input->post('time_in'));
                $time_out = new DateTime($this->input->post('time_out'));
                $interval = $time_in->diff($time_out);
                
                $hours = $interval->h + ($interval->i / 60);
                if ($hours >= 5) { $hours -= 1; }

                $logData['log_date']       = $this->input->post('log_date');
                $logData['time_in']        = $this->input->post('time_in');
                $logData['time_out']       = $this->input->post('time_out');
                $logData['hours_rendered'] = max(0, $hours);
            }

            $this->db->where('id', $id)->update('ojt_logs', $logData);
            $this->session->set_flashdata('success', 'Log updated successfully!');
        }

        redirect('ojt');
    }

    public function delete_log($id) {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Only administrators can delete OJT logs.', 403);
            return;
        }

        if (is_numeric($id)) {
            $this->db->where('id', $id)->delete('ojt_logs');
            $this->session->set_flashdata('success', 'Log deleted successfully!');
        }

        redirect('portfolio');
    }

    public function request_deletion() {
        $user_id = $this->session->userdata('user_id');
        $log_id = $this->input->post('log_id');

        if (empty($user_id) || !is_numeric($log_id)) {
            show_error('Invalid deletion request.', 400);
            return;
        }

        $log = $this->db->get_where('ojt_logs', array(
            'id' => $log_id,
            'user_id' => $user_id
        ))->row_array();

        if (empty($log)) {
            show_error('The requested OJT log was not found.', 404);
            return;
        }

        $this->db->insert('messages', array(
            'sender_name'  => trim($this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name')),
            'sender_email' => $this->session->userdata('email'),
            'subject'      => 'OJT Log Deletion Request #' . $log_id,
            'message_text' => 'Please review my request to delete OJT log #' . $log_id . ' dated ' . $log['log_date'] . '.',
            'is_read'      => 0
        ));

        $this->session->set_flashdata('success', 'Deletion request sent to the administrator.');
        redirect('ojt');
    }

// Feature 3 & 6: Analytics Dashboard & Weekly Goal Progress Ring
public function analytics() {
    $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

    // 1. Fetch total hours rendered for current week (Mon-Sun)
    $monday = date('Y-m-d', strtotime('monday this week'));
    $sunday = date('Y-m-d', strtotime('sunday this week'));
    
    $this->db->select_sum('hours_rendered');
    $this->db->where('user_id', $user_id);
    $this->db->where('log_date >=', $monday);
    $this->db->where('log_date <=', $sunday);
    $weekly_data = $this->db->get('ojt_logs')->row();
    $weekly_hours = $weekly_data->hours_rendered ? $weekly_data->hours_rendered : 0;

    // 2. Fetch daily hours for current week to populate Chart.js
    $daily_chart = array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0, 'Fri' => 0, 'Sat' => 0, 'Sun' => 0);
    $this->db->select('log_date, SUM(hours_rendered) as total_hours');
    $this->db->where('user_id', $user_id);
    $this->db->where('log_date >=', $monday);
    $this->db->where('log_date <=', $sunday);
    $this->db->group_by('log_date');
    $logs = $this->db->get('ojt_logs')->result_array();

    foreach ($logs as $log) {
        $day_name = date('D', strtotime($log['log_date']));
        if (isset($daily_chart[$day_name])) {
            $daily_chart[$day_name] = (float)$log['total_hours'];
        }
    }

    $data = array(
        'page_title'   => 'OJT Analytics & Weekly Goals',
        'weekly_hours' => $weekly_hours,
        'weekly_goal'  => 40.0, // Standard 40-hr OJT weekly target
        'chart_labels' => json_encode(array_keys($daily_chart)),
        'chart_data'   => json_encode(array_values($daily_chart))
    );

    $this->load->view('ojt_analytics', $data);
}

// Feature 2: Detailed DTR Log Records with Date Range Filter & Search
public function logs() {
    $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

    // Read GET query parameters for filtering
    $search    = $this->input->get('search', TRUE);
    $start_date = $this->input->get('start_date', TRUE);
    $end_date   = $this->input->get('end_date', TRUE);

    $this->db->where('user_id', $user_id);

    if (!empty($search)) {
        $this->db->like('task_summary', $search);
    }
    if (!empty($start_date)) {
        $this->db->where('log_date >=', $start_date);
    }
    if (!empty($end_date)) {
        $this->db->where('log_date <=', $end_date);
    }

    $this->db->order_by('log_date', 'DESC');
    $this->db->order_by('id', 'DESC');
    $logs = $this->db->get('ojt_logs')->result_array();

    $data = array(
        'page_title' => 'DTR Filter & Search Records',
        'logs'       => $logs,
        'search'     => $search,
        'start_date' => $start_date,
        'end_date'   => $end_date
    );

    $this->load->view('ojt_logs_view', $data);
}

// Feature 4: Printable / Export DTR Report
public function export_pdf() {
    $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

    // Fetch user info
    $user = $this->db->get_where('users', array('id' => $user_id))->row_array();

    // Fetch all logs
    $this->db->where('user_id', $user_id);
    $this->db->order_by('log_date', 'ASC');
    $logs = $this->db->get('ojt_logs')->result_array();

    // Total hours sum
    $this->db->select_sum('hours_rendered');
    $this->db->where('user_id', $user_id);
    $total_hours = $this->db->get('ojt_logs')->row()->hours_rendered;

    $data = array(
        'student_name' => isset($user['name']) ? $user['name'] : 'Aerhon Louis Magtira',
        'student_id'   => isset($user['student_id']) ? $user['student_id'] : '202200702',
        'logs'         => $logs,
        'total_hours'  => $total_hours ? $total_hours : 0.00
    );

    // Loads printable browser document view (supports Ctrl+P or save as PDF directly)
    $this->load->view('ojt_pdf_template', $data);
}

// In application/controllers/Ojt.php

public function analytics_partial() {
    // Renders only the inner analytics card content
    $this->load->view('ojt/analytics_view');
}

public function logs_partial() {
    // Renders only the inner DTR records & filter card content
    $this->load->view('ojt/logs_view');
}

public function update_info() {
    $user_id = $this->session->userdata('user_id');

    if ($user_id) {
        // Collect posted inputs
        $update_data = array(
            'first_name'    => $this->input->post('first_name', TRUE),
            'middle_name'   => $this->input->post('middle_name', TRUE),
            'last_name'     => $this->input->post('last_name', TRUE),
            'gender'        => $this->input->post('gender', TRUE),
            'birthday'      => $this->input->post('birthday', TRUE),
            'school'        => $this->input->post('school', TRUE),
            'year_section'  => $this->input->post('year_section', TRUE),
            'academic_year' => $this->input->post('academic_year', TRUE),
            'semester'      => $this->input->post('semester', TRUE)
        );

        // Update database record
        $this->db->where('id', $user_id);
        $this->db->update('users', $update_data);

        // Update session values so the UI reflects changes immediately
        $this->session->set_userdata($update_data);
        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Personal information updated successfully!'
        ));
        return;
    }

    echo json_encode(array(
        'status'  => 'error',
        'message' => 'User session expired or invalid request.'
    ));
}

    public function update_password() {
    $user_id = $this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array('status' => 'error', 'message' => 'Session expired. Please log in again.'));
        return;
    }

    $current_password = $this->input->post('current_password', TRUE);
    $new_password     = $this->input->post('new_password', TRUE);
    $confirm_password = $this->input->post('confirm_password', TRUE);

    // Validate empty fields
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(array('status' => 'error', 'message' => 'All fields are required.'));
        return;
    }

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo json_encode(array('status' => 'error', 'message' => 'New password and confirmation do not match.'));
        return;
    }

    // Check if new password is identical to current password
    if ($current_password === $new_password) {
        echo json_encode(array('status' => 'error', 'message' => 'New password cannot be the same as your current password.'));
        return;
    }

    // Validate password complexity requirements
    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($password_pattern, $new_password)) {
        echo json_encode(array(
            'status' => 'error', 
            'message' => 'New password does not meet all security requirements.'
        ));
        return;
    }

    // Retrieve current user record
    $user = $this->db->get_where('users', array('id' => $user_id))->row();

    // Verify current password (supports password_hash or md5 fallback)
    $password_matches = password_verify($current_password, $user->password) || (md5($current_password) === $user->password);

    if (!$user || !$password_matches) {
        echo json_encode(array('status' => 'error', 'message' => 'Incorrect current password.'));
        return;
    }

    // Hash and update the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $this->db->where('id', $user_id);
    $this->db->update('users', array('password' => $hashed_password));

    echo json_encode(array('status' => 'success', 'message' => 'Password updated successfully!'));
}

public function update_email() {
    // Set response header to JSON
    header('Content-Type: application/json');

    $user_id = $this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array('status' => 'error', 'message' => 'Session expired. Please log in again.'));
        return;
    }

    $new_email = $this->input->post('new_email', TRUE);
    $current_password = $this->input->post('current_password', TRUE);

    // 1. Validate empty inputs
    if (empty($new_email) || empty($current_password)) {
        echo json_encode(array('status' => 'error', 'message' => 'All fields are required.'));
        return;
    }

    // 2. Validate email format
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('status' => 'error', 'message' => 'Please enter a valid email address.'));
        return;
    }

    // 3. Fetch current user from database
    $user = $this->db->get_where('users', array('id' => $user_id))->row();

    if (!$user) {
        echo json_encode(array('status' => 'error', 'message' => 'User account not found.'));
        return;
    }

    // 4. Check if current password is correct (supports password_hash or md5 fallback)
    $password_matches = password_verify($current_password, $user->password) || (md5($current_password) === $user->password);

    if (!$password_matches) {
        echo json_encode(array('status' => 'error', 'message' => 'Incorrect current password.'));
        return;
    }

    // 5. Check if new email is already taken by another user
    $existing_email = $this->db->get_where('users', array('email' => $new_email, 'id !=' => $user_id))->row();
    if ($existing_email) {
        echo json_encode(array('status' => 'error', 'message' => 'This email address is already in use by another account.'));
        return;
    }

    // 6. Update email in database and update session data
    $this->db->where('id', $user_id);
    $this->db->update('users', array('email' => $new_email));
    $this->session->set_userdata('email', $new_email);

    echo json_encode(array('status' => 'success', 'message' => 'Email address updated successfully!'));
}

}