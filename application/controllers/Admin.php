<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'security'));
        $this->load->database();
        $this->load->model('Ojt_model');
    }

    private function require_admin() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/admin_login');
            return FALSE;
        }
        return TRUE;
    }

    // DEVELOPMENT ONLY: Auto-authenticate as admin and redirect to dashboard
    public function dev_login() {
        $admin = $this->db->where('role', 'admin')->limit(1)->get('users')->row_array();
        
        if (!$admin) {
            $this->session->set_flashdata('error', 'No admin account found. Please create one first.');
            redirect('auth/admin_login');
            return;
        }

        $this->session->set_userdata(array(
            'user_id'    => $admin['id'],
            'first_name' => $admin['first_name'] ?? '',
            'last_name'  => $admin['last_name'] ?? '',
            'email'      => $admin['email'] ?? $admin['username'],
            'username'   => $admin['username'],
            'role'       => 'admin',
            'logged_in'  => TRUE,
            'dev_mode'   => TRUE
        ));

        redirect('admin');
    }

    public function index() {
        if (!$this->require_admin()) {
            return;
        }

        // Only count approved/active interns (admin-verified accounts)
    $data['interns'] = $this->db
        ->select('users.*, COALESCE(SUM(ojt_logs.hours_rendered), 0) AS rendered_hours')
        ->from('users')
        ->join('ojt_logs', 'ojt_logs.user_id = users.id', 'left')
        ->where('users.role', 'intern')
        ->where_in('users.account_status', array('approved', 'active'))
        ->group_by('users.id')
        ->order_by('users.id', 'DESC')
        ->get()->result_array();
    $data['intern_count'] = count($data['interns']);
        
        $data['rejected_interns'] = $this->db
            ->where('role', 'intern')->where('account_status', 'rejected')
            ->order_by('id', 'DESC')->get('users')->result_array();
        $data['rejected_intern_count'] = count($data['rejected_interns']);

        $today = date('Y-m-d');
        $scheduled_start_time = '08:00:00';
        $data['time_ins_today'] = $this->db
            ->where('log_date', $today)
            ->where('time_in IS NOT NULL', NULL, FALSE)
            ->count_all_results('ojt_logs');
        $data['late_today'] = $this->db
            ->where('log_date', $today)
            ->where('time_in >', $scheduled_start_time)
            ->count_all_results('ojt_logs');
        $data['log_count'] = $this->db->count_all('ojt_logs');
        
        $data['pending_intern_count'] = $this->db
            ->where('role', 'intern')
            ->where('account_status', 'pending')
            ->count_all_results('users');
        $data['request_count'] = $this->db->like('subject', 'OJT Log Deletion Request')->where('is_read', 0)->count_all_results('messages');
        $data['pending_count'] = $data['pending_intern_count'] + $data['request_count'];
        
        $data['newly_approved_interns'] = $this->db
            ->where('role', 'intern')->where('account_status', 'approved')
            ->order_by('created_at', 'DESC')->limit(3)->get('users')->result_array();
        $data['interns_to_approve'] = $this->db
            ->where('role', 'intern')->where('account_status', 'pending')
            ->order_by('created_at', 'ASC')->limit(3)->get('users')->result_array();
            
        $this->ensure_announcement_target_column();
        $this->Ojt_model->ensure_support_tables();
        
        $data['announcements'] = $this->db
            ->select('announcements.*, users.first_name, users.last_name, recipients.first_name AS recipient_first_name, recipients.last_name AS recipient_last_name')
            ->from('announcements')
            ->join('users', 'users.id = announcements.admin_id', 'left')
            ->join('users AS recipients', 'recipients.id = announcements.target_user_id', 'left')
            ->order_by('announcements.created_at', 'DESC')
            ->get()->result_array();
        $data['announcement_interns'] = $this->db
            ->select('id, first_name, last_name, email')
            ->where('role', 'intern')->where('account_status', 'approved')
            ->order_by('first_name', 'ASC')->get('users')->result_array();
        $data['inquiries'] = $this->Ojt_model->get_all_inquiries();
        // Inbox inquiries data (for inbox dropdown)
            $data['inbox_inquiries'] = $this->db
                ->select('inquiries.id, inquiries.subject, inquiries.message, inquiries.category, inquiries.created_at, users.first_name, users.last_name, inquiries.status')
                ->from('inquiries')
                ->join('users', 'users.id = inquiries.user_id', 'left')
                ->where('inquiries.status', 'Open')
                ->order_by('inquiries.created_at', 'DESC')
                ->limit(5)
                ->get()->result_array();
            $data['inbox_inquiry_count'] = count($data['inbox_inquiries']);
        $data['active_module'] = $this->session->flashdata('active_module');
        
        $data['required_hours'] = 500;
        $profile = $this->db->get_where('user_profile', array('id' => 1))->row_array();
        if (!empty($profile['required_hours'])) {
            $data['required_hours'] = (float)$profile['required_hours'];
        }

        $data['recent_logs'] = $this->db
            ->select('ojt_logs.*, users.first_name, users.last_name, users.email, users.role_position')
            ->from('ojt_logs')
            ->join('users', 'users.id = ojt_logs.user_id', 'left')
            ->order_by('ojt_logs.log_date', 'DESC')
            ->get()->result_array();
        $data['requests'] = $this->db->like('subject', 'OJT Log Deletion Request')->where('is_read', 0)->order_by('id', 'DESC')->limit(3)->get('messages')->result_array();
        $data['latest_attendance'] = $data['recent_logs'];

        $data['departments'] = $this->db
            ->select('COALESCE(NULLIF(school, \'\'), \'Unassigned\') AS department, COUNT(*) AS intern_count')
            ->where('role', 'intern')
            ->where('account_status !=', 'rejected')
            ->group_by('school')
            ->order_by('intern_count', 'DESC')
            ->get('users')->result_array();
            
        $data['at_risk_interns'] = array();
        foreach ($data['interns'] as $intern) {
            $progress = $data['required_hours'] > 0 ? ((float)$intern['rendered_hours'] / $data['required_hours']) * 100 : 0;
            if ($progress < 25) {
                $intern['progress'] = min(100, round($progress, 1));
                $data['at_risk_interns'][] = $intern;
            }
        }

        // ==========================================
        // NEW ANALYTICS & CHART DATA CALCULATIONS
        // (Excludes rejected interns from all metrics)
        // ==========================================
        
        // 1. Interns Registered This Month (Excluding rejected)
        $data['this_month_interns'] = $this->db
            ->where('role', 'intern')
            ->where_in('account_status', array('approved', 'active'))
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->get('users')->num_rows();

        // 2. Total Hours Rendered (Excluding rejected)
        $this->db->select_sum('ojt_logs.hours_rendered')
                 ->from('ojt_logs')
                 ->join('users', 'users.id = ojt_logs.user_id')
                 ->where('users.role', 'intern')
                 ->where('users.account_status !=', 'rejected');
        $total_hours_query = $this->db->get()->row();
        $data['total_hours_rendered'] = (float)($total_hours_query->hours_rendered ?? 0);

        // 3. Gender Distribution (Pie Chart) + Names
        $this->db->select("COALESCE(NULLIF(gender, ''), 'Unspecified') as gender, COUNT(*) as count")
                 ->where('role', 'intern')
                 ->where('account_status !=', 'rejected')
                 ->group_by('gender');
        $gender_query = $this->db->get('users')->result_array();
        $data['gender_distribution'] = [
            'labels' => array_column($gender_query, 'gender'),
            'values' => array_column($gender_query, 'count')
        ];
        
        $intern_names_by_gender = [];
        foreach ($gender_query as $g) {
            $this->db->select("CONCAT(first_name, ' ', last_name) as full_name")
                     ->where('role', 'intern')
                     ->where('account_status !=', 'rejected');
            if ($g['gender'] === 'Unspecified') {
                $this->db->group_start()->where('gender', '')->or_where('gender IS NULL')->group_end();
            } else {
                $this->db->where('gender', $g['gender']);
            }
            $names = $this->db->get('users')->result_array();
            $intern_names_by_gender[$g['gender']] = array_column($names, 'full_name');
        }
        $data['intern_names_by_gender'] = $intern_names_by_gender;

        // 4. School/Department Distribution (Bar Chart) + Names
        $this->db->select("COALESCE(NULLIF(school, ''), 'Unassigned') as school, COUNT(*) as count")
                 ->where('role', 'intern')
                 ->where('account_status !=', 'rejected')
                 ->group_by('school')
                 ->order_by('count', 'DESC');
        $school_query = $this->db->get('users')->result_array();
        $data['school_distribution'] = [
            'labels' => array_column($school_query, 'school'),
            'values' => array_column($school_query, 'count')
        ];

        $intern_names_by_school = [];
        foreach ($school_query as $s) {
            $this->db->select("CONCAT(first_name, ' ', last_name) as full_name")
                     ->where('role', 'intern')
                     ->where('account_status !=', 'rejected');
            if ($s['school'] === 'Unassigned') {
                $this->db->group_start()->where('school', '')->or_where('school IS NULL')->group_end();
            } else {
                $this->db->where('school', $s['school']);
            }
            $names = $this->db->get('users')->result_array();
            $intern_names_by_school[$s['school']] = array_column($names, 'full_name');
        }
        $data['intern_names_by_school'] = $intern_names_by_school;

        // 5. Monthly Registration Trend (Line Chart) + Names
        $this->db->select("DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as count")
                 ->where('role', 'intern')
                 ->where('account_status !=', 'rejected')
                 ->group_by('month')
                 ->order_by('MIN(created_at)', 'ASC')
                 ->limit(6);
        $monthly_query = $this->db->get('users')->result_array();
        $data['monthly_registration'] = [
            'labels' => array_column($monthly_query, 'month'),
            'values' => array_column($monthly_query, 'count')
        ];

        $intern_names_by_month = [];
        foreach ($monthly_query as $m) {
           // 5. Monthly Registration Trend (Line Chart) + Names
            $this->db->select("DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as count")
                    ->where('role', 'intern')
                    ->where('account_status !=', 'rejected')
                    ->group_by('month')
                    ->order_by('MIN(created_at)', 'ASC')
                    ->limit(6);
            $monthly_query = $this->db->get('users')->result_array();
            $data['monthly_registration'] = [
                'labels' => array_column($monthly_query, 'month'),
                'values' => array_column($monthly_query, 'count')
            ];

            $intern_names_by_month = [];
            foreach ($monthly_query as $m) {
                $this->db->select("CONCAT(first_name, ' ', last_name) as full_name")
                        ->where('role', 'intern')
                        ->where('account_status !=', 'rejected');
                // FIX: Use having-like condition with proper syntax
                $this->db->where("DATE_FORMAT(created_at, '%b %Y') =", $m['month']);
                $names = $this->db->get('users')->result_array();
                $intern_names_by_month[$m['month']] = array_column($names, 'full_name');
            }
            $data['intern_names_by_month'] = $intern_names_by_month;

        // 6. Status Distribution (Doughnut Chart) + Names
        $this->db->select("CASE 
                WHEN account_status = 'approved' THEN 'Active'
                WHEN account_status = 'pending' THEN 'Pending'
                WHEN account_status = 'done' THEN 'Done'
                ELSE COALESCE(NULLIF(account_status, ''), 'Unknown') 
            END as status, COUNT(*) as count")
                 ->where('role', 'intern')
                 ->where('account_status !=', 'rejected')
                 ->group_by('status');
        $status_query = $this->db->get('users')->result_array();
        $data['status_distribution'] = [
            'labels' => array_column($status_query, 'status'),
            'values' => array_column($status_query, 'count')
        ];

        $intern_names_by_status = [];
        $db_status_map = ['Active' => 'approved', 'Pending' => 'pending', 'Done' => 'done'];
        foreach ($status_query as $st) {
            $db_status = $db_status_map[$st['status']] ?? $st['status'];
            $this->db->select("CONCAT(first_name, ' ', last_name) as full_name")
                     ->where('role', 'intern')
                     ->where('account_status !=', 'rejected')
                     ->where('account_status', $db_status);
            $names = $this->db->get('users')->result_array();
            $intern_names_by_status[$st['status']] = array_column($names, 'full_name');
        }
        $data['intern_names_by_status'] = $intern_names_by_status;

        // 7. Current Academic Year
        $current_year = date('Y');
        $data['academic_year'] = $current_year . '-' . ($current_year + 1);

        // 8. This Month Interns List (for modal) - exclude rejected
        $data['this_month_interns_list'] = $this->db
            ->select('id, first_name, last_name, email, school, account_status, created_at')
            ->where('role', 'intern')
            ->where('account_status !=', 'rejected')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->order_by('created_at', 'DESC')
            ->get('users')
            ->result_array();
        // ==========================================

        // ==========================================
        // HOURS & PROGRESSION METRICS CALCULATIONS
        // ==========================================

        // 1. Pending Hours Approval
        $pending_query = $this->db->select('users.id, users.first_name, users.last_name, users.school, 
                                            COUNT(ojt_logs.id) as pending_logs, 
                                            COALESCE(SUM(ojt_logs.hours_rendered), 0) as pending_hours,
                                            MAX(ojt_logs.created_at) as latest_submission')
            ->from('users')
            ->join('ojt_logs', 'ojt_logs.user_id = users.id AND ojt_logs.status = "Pending"', 'inner')
            ->where('users.role', 'intern')
            ->where('users.account_status', 'approved')
            ->group_by('users.id')
            ->order_by('pending_hours', 'DESC')
            ->get()
            ->result_array();
        $data['pending_approval_interns'] = $pending_query;

        // 2. Behind Schedule
        $weeks_elapsed = max(1, ceil((time() - strtotime('2026-06-01')) / (7 * 24 * 60 * 60)));
        $hours_per_week = $data['required_hours'] / 16;
        $expected_hours = $weeks_elapsed * $hours_per_week;

        $behind_interns = array();
        foreach ($data['interns'] as $intern) {
            $rendered = (float)$intern['rendered_hours'];
            if ($rendered < $expected_hours) {
                $progress = $data['required_hours'] > 0 ? ($rendered / $data['required_hours']) * 100 : 0;
                $behind_interns[] = array(
                    'id' => $intern['id'],
                    'first_name' => $intern['first_name'],
                    'last_name' => $intern['last_name'],
                    'school' => $intern['school'],
                    'rendered_hours' => $rendered,
                    'expected_hours' => $expected_hours,
                    'shortfall' => $expected_hours - $rendered,
                    'progress' => round($progress, 1)
                );
            }
        }
        usort($behind_interns, function($a, $b) {
            return $b['shortfall'] <=> $a['shortfall'];
        });
        $data['behind_schedule_interns'] = $behind_interns;

        // 3. Near Completion (80%+ done)
        $near_completion = array();
        foreach ($data['interns'] as $intern) {
            $rendered = (float)$intern['rendered_hours'];
            $progress = $data['required_hours'] > 0 ? ($rendered / $data['required_hours']) * 100 : 0;
            if ($progress >= 80 && $progress < 100) {
                $near_completion[] = array(
                    'id' => $intern['id'],
                    'first_name' => $intern['first_name'],
                    'last_name' => $intern['last_name'],
                    'school' => $intern['school'],
                    'rendered_hours' => $rendered,
                    'remaining_hours' => $data['required_hours'] - $rendered,
                    'progress' => round($progress, 1)
                );
            }
        }
        usort($near_completion, function($a, $b) {
            return $b['progress'] <=> $a['progress'];
        });
        $data['near_completion_interns'] = $near_completion;
        // ==========================================

        $this->load->view('admin/dashboard', $data);
    }
    }
    public function update_intern($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $update_data = array(
            'first_name'    => trim($this->input->post('first_name', TRUE)),
            'middle_name'   => trim($this->input->post('middle_name', TRUE)),
            'last_name'     => trim($this->input->post('last_name', TRUE)),
            'email'         => strtolower(trim($this->input->post('email', TRUE))),
            'student_id'    => trim($this->input->post('student_id', TRUE)),
            'school'        => trim($this->input->post('school', TRUE)),
            'year_section'  => trim($this->input->post('year_section', TRUE)),
            'academic_year' => trim($this->input->post('academic_year', TRUE)),
            'semester'      => trim($this->input->post('semester', TRUE)),
            'account_status' => strtolower($this->input->post('status')),
            'role_position' => trim($this->input->post('role_position', TRUE))
        );

        if ($id <= 0 || empty($update_data['first_name']) || empty($update_data['last_name']) || !filter_var($update_data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Please provide a valid intern name and email.');
            $this->session->set_flashdata('active_module', 'intern-management');
            redirect('admin');
            return;
        }

        $this->db->where('id', $id)->where('role', 'intern')->update('users', $update_data);
        $this->session->set_flashdata('success', 'Intern information updated successfully.');
        $this->session->set_flashdata('active_module', 'intern-management');
        
        redirect('admin');
    }

    public function approve_intern($id) {
        if (!$this->require_admin()) {
            return;
        }

        $this->db
        ->where('id', (int)$id)
        ->where('role', 'intern')
        ->where('account_status', 'pending')
        ->update('users', array('account_status' => 'approved'));

        $this->session->set_flashdata('success', 'Intern account approved successfully.');
        
        $redirect = $this->input->get('redirect', TRUE);
        $redirect_url = ($redirect && $redirect === 'pending-approvals') ? 'admin#pending-approvals' : 'admin';
        redirect($redirect_url);
    }

    public function reject_intern($id) {
        if (!$this->require_admin()) {
            return;
        }

        $this->db
            ->where('id', (int)$id)
            ->where('role', 'intern')
            ->where('account_status', 'pending')
            ->update('users', array('account_status' => 'rejected'));
        $this->session->set_flashdata('success', 'Intern registration request denied.');
        
        $redirect = $this->input->get('redirect', TRUE);
        $redirect_url = ($redirect && $redirect === 'pending-approvals') ? 'admin#pending-approvals' : 'admin';
        redirect($redirect_url);
    }

    public function update_log($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $status = trim($this->input->post('status', TRUE));
        $allowed_statuses = array('active', 'Pending', 'Approved', 'Rejected', 'Completed');
        if (!in_array($status, $allowed_statuses, TRUE)) {
            $status = 'Pending';
        }

        $update_data = array(
            'log_date'       => trim($this->input->post('log_date', TRUE)),
            'time_in'        => trim($this->input->post('time_in', TRUE)),
            'time_out'       => trim($this->input->post('time_out', TRUE)),
            'hours_rendered' => (float)trim($this->input->post('hours_rendered', TRUE)),
            'task_summary'   => trim($this->input->post('task_summary', TRUE)),
            'status'         => $status
        );

        if ($id <= 0 || empty($update_data['log_date']) || empty($update_data['time_in'])) {
            $this->session->set_flashdata('error', 'Date and time-in are required.');
            $this->session->set_flashdata('active_module', 'ojt-management');
            redirect('admin');
            return;
        }

        $this->db->where('id', $id)->update('ojt_logs', $update_data);
        $this->session->set_flashdata('success', 'OJT record updated successfully.');
        $this->session->set_flashdata('active_module', 'ojt-management');
        
        redirect('admin');
    }

    public function delete_log($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        if ($id > 0) {
            $this->db->where('id', $id)->delete('ojt_logs');
            $this->session->set_flashdata('success', 'OJT record deleted successfully.');
        }
        
        $this->session->set_flashdata('active_module', 'ojt-management');
        redirect('admin');
    }

    public function mark_request_read($id) {
        if (!$this->require_admin()) {
            return;
        }

        $this->db->where('id', (int)$id)->update('messages', array('is_read' => 1));
        $this->session->set_flashdata('success', 'Deletion request marked as reviewed.');
        
        $redirect = $this->input->get('redirect', TRUE);
        $redirect_url = ($redirect && $redirect === 'pending-approvals') ? 'admin#pending-approvals' : 'admin';
        redirect($redirect_url);
    }

    public function clear_deletion_requests() {
        if (!$this->require_admin()) {
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') {
            show_error('Invalid request method.', 405);
            return;
        }

        $this->db->like('subject', 'OJT Log Deletion Request')->delete('messages');
        $this->session->set_flashdata('success', 'Deletion requests cleared successfully.');
        
        $redirect = $this->input->post('redirect', TRUE);
        $redirect_url = ($redirect && $redirect === 'pending-approvals') ? 'admin#pending-approvals' : 'admin';
        redirect($redirect_url);
    }

    public function inquiries() {
        if (!$this->require_admin()) {
            return;
        }

        $this->session->set_flashdata('active_module', 'inquiries');
        redirect('admin');
    }

    public function reply_to_inquiry($id) {
        if (!$this->require_admin()) {
            return;
        }

        $reply = trim($this->input->post('admin_reply', TRUE));
        if ((int)$id <= 0 || empty($reply)) {
            $this->session->set_flashdata('error', 'An inquiry reply is required.');
            $this->session->set_flashdata('active_module', 'inquiries');
            redirect('admin#inquiries');
            return;
        }

        $this->Ojt_model->ensure_support_tables();
        $this->Ojt_model->reply_to_inquiry($id, $reply);
        $this->session->set_flashdata('success', 'Inquiry reply sent successfully.');
        $this->session->set_flashdata('active_module', 'inquiries');
        
        $redirect = $this->input->post('redirect', TRUE);
        $redirect_url = ($redirect && $redirect === 'inquiries') ? 'admin#inquiries' : 'admin';
        redirect($redirect_url);
    }

    public function create_admin() {
        if (!$this->require_admin()) {
            return;
        }
        $this->load->view('admin/create_admin');
    }

    public function create_admin_process() {
        if (!$this->require_admin()) {
            return;
        }

        $first_name = trim($this->input->post('first_name', TRUE));
        $last_name = trim($this->input->post('last_name', TRUE));
        $email = strtolower(trim($this->input->post('email', TRUE)));
        $username = trim($this->input->post('username', TRUE));
        $password = $this->input->post('password', TRUE);

        if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'All fields are required.');
            redirect('admin/create_admin');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Invalid email format.');
            redirect('admin/create_admin');
            return;
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($pattern, $password)) {
            $this->session->set_flashdata('error', 'Password must be at least 8 characters with uppercase, lowercase, number, and special character.');
            redirect('admin/create_admin');
            return;
        }

        $this->db->group_start()
                 ->where('email', $email)
                 ->or_where('username', $username)
                 ->group_end();
        $existing = $this->db->get('users')->row();
        if ($existing) {
            $this->session->set_flashdata('error', 'An account with this email or username already exists.');
            redirect('admin/create_admin');
            return;
        }

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'admin',
            'account_status' => 'approved'
        );

        if ($this->db->insert('users', $data)) {
            $this->session->set_flashdata('success', "Admin account created successfully for $first_name $last_name.");
            redirect('admin/create_admin');
        } else {
            $this->session->set_flashdata('error', 'Failed to create admin account. Please try again.');
            redirect('admin/create_admin');
        }
    }

    public function announcements() {
        if (!$this->require_admin()) {
            return;
        }
        $this->session->set_flashdata('active_module', 'announcements');
        redirect('admin');
    }

    public function create_announcement() {
        if (!$this->require_admin()) {
            return;
        }
        $this->load->view('admin/create_announcement');
    }

    public function create_announcement_process() {
        if (!$this->require_admin()) {
            return;
        }

        $this->ensure_announcement_target_column();
        $title = trim($this->input->post('title', TRUE));
        $message = trim($this->input->post('message', TRUE));
        $category = trim($this->input->post('category', TRUE));
        $expires_at = trim($this->input->post('expires_at', TRUE));
        $target_type = $this->input->post('target_type', TRUE);
        $target_user_id = (int)$this->input->post('target_user_id', TRUE);

        if (empty($title) || empty($message)) {
            $this->session->set_flashdata('error', 'Title and message are required.');
            $this->session->set_flashdata('active_module', 'announcements');
            redirect('admin#announcements');
            return;
        }

        if (!in_array($target_type, array('all', 'specific'), TRUE)) {
            $target_type = 'all';
        }

        if ($target_type === 'specific') {
            $recipient = $this->db
                ->where('id', $target_user_id)
                ->where('role', 'intern')
                ->where('account_status', 'approved')
                ->get('users')->row_array();
            if (empty($recipient)) {
                $this->session->set_flashdata('error', 'Please select an approved intern recipient.');
                $this->session->set_flashdata('active_module', 'announcements');
                redirect('admin#announcements');
                return;
            }
        }

        $data = array(
            'admin_id' => $this->session->userdata('user_id'),
            'title' => $title,
            'message' => $message,
            'category' => $category,
            'expires_at' => $this->normalize_announcement_expiration($expires_at),
            'target_user_id' => $target_type === 'specific' ? $target_user_id : NULL,
            'is_active' => 1
        );

        if ($this->db->insert('announcements', $data)) {
            $this->session->set_flashdata('success', $target_type === 'specific' ? 'Announcement sent to the selected intern.' : 'Announcement broadcast to all approved interns.');
            $this->session->set_flashdata('active_module', 'announcements');
            redirect('admin#announcements');
        } else {
            $this->session->set_flashdata('error', 'Failed to create announcement. Please try again.');
            $this->session->set_flashdata('active_module', 'announcements');
            redirect('admin#announcements');
        }
    }

    private function ensure_announcement_target_column() {
        if (!$this->db->field_exists('target_user_id', 'announcements')) {
            $this->db->query('ALTER TABLE announcements ADD target_user_id INT NULL AFTER admin_id');
        }
    }

    private function normalize_announcement_expiration($expires_at) {
        return !empty($expires_at) ? date('Y-m-d 23:59:59', strtotime($expires_at)) : NULL;
    }

    public function edit_announcement($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $data['announcement'] = $this->db->where('id', $id)->get('announcements')->row_array();

        if (empty($data['announcement'])) {
            $this->session->set_flashdata('error', 'Announcement not found.');
            redirect('admin/announcements');
            return;
        }

        $this->load->view('admin/edit_announcement', $data);
    }

    public function update_announcement($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $title = trim($this->input->post('title', TRUE));
        $message = trim($this->input->post('message', TRUE));
        $category = trim($this->input->post('category', TRUE));
        $expires_at = trim($this->input->post('expires_at', TRUE));
        $is_active = (int)$this->input->post('is_active', TRUE);

        if (empty($title) || empty($message)) {
            $this->session->set_flashdata('error', 'Title and message are required.');
            redirect('admin/edit_announcement/' . $id);
            return;
        }

        $update_data = array(
            'title' => $title,
            'message' => $message,
            'category' => $category,
            'expires_at' => $this->normalize_announcement_expiration($expires_at),
            'is_active' => $is_active
        );

        $this->db->where('id', $id)->update('announcements', $update_data);
        $this->session->set_flashdata('success', 'Announcement updated successfully.');
        redirect('admin/announcements');
    }

    public function delete_announcement($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $this->db->where('id', $id)->delete('announcements');
        $this->session->set_flashdata('success', 'Announcement deleted successfully.');
        redirect('admin/announcements');
    }

    public function interns() {
        if (!$this->require_admin()) {
            return;
        }
        $this->session->set_flashdata('active_module', 'interns');
        redirect('admin#intern-management');
    }

    public function analytics() {
        if (!$this->require_admin()) {
            return;
        }
        // Load the same data as index()
        $this->index(); // or duplicate the data loading logic
    }

    public function view_dtr($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        
        // Get intern details
        $data['intern'] = $this->db
            ->select('users.*, COALESCE(SUM(ojt_logs.hours_rendered), 0) AS total_hours')
            ->from('users')
            ->join('ojt_logs', 'ojt_logs.user_id = users.id', 'left')
            ->where('users.id', $id)
            ->where('users.role', 'intern')
            ->group_by('users.id')
            ->get()->row_array();

        if (empty($data['intern'])) {
            show_404();
            return;
        }

        // Get month filter
        $selected_month = $this->input->get('month');
        $selected_year = $this->input->get('year');
        
        $data['selected_month'] = $selected_month ?: date('m');
        $data['selected_year'] = $selected_year ?: date('Y');

        // Get all OJT logs for this intern with optional month filter
        $this->db->select('ojt_logs.*, users.first_name, users.last_name')
                ->from('ojt_logs')
                ->join('users', 'users.id = ojt_logs.user_id')
                ->where('ojt_logs.user_id', $id)
                ->order_by('ojt_logs.log_date', 'DESC');

        if (!empty($selected_month) && !empty($selected_year)) {
            $this->db->where('MONTH(ojt_logs.log_date)', $selected_month);
            $this->db->where('YEAR(ojt_logs.log_date)', $selected_year);
        }

        $data['dtr_logs'] = $this->db->get()->result_array();

        // Calculate totals for filtered period
        $this->db->select('COUNT(*) as total_logs, COALESCE(SUM(hours_rendered), 0) as total_hours')
                ->from('ojt_logs')
                ->where('user_id', $id);
        if (!empty($selected_month) && !empty($selected_year)) {
            $this->db->where('MONTH(log_date)', $selected_month);
            $this->db->where('YEAR(log_date)', $selected_year);
        }
        $totals = $this->db->get()->row();
        $data['filtered_total_logs'] = (int)$totals->total_logs;
        $data['filtered_total_hours'] = (float)$totals->total_hours;

        // Get available months for filter dropdown
        $data['available_months'] = $this->db
            ->select("DISTINCT DATE_FORMAT(log_date, '%Y-%m') as month")
            ->from('ojt_logs')
            ->where('user_id', $id)
            ->order_by('month', 'DESC')
            ->get()->result_array();

        $this->load->view('admin/view_dtr', $data);
    }
}