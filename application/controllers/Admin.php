<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'security'));
        $this->load->database();
    }

    private function require_admin() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/admin_login');
            return FALSE;
        }
        return TRUE;
    }

    public function index() {
        if (!$this->require_admin()) {
            return;
        }

        $data['interns'] = $this->db
            ->select('users.*, COALESCE(SUM(ojt_logs.hours_rendered), 0) AS rendered_hours')
            ->from('users')
            ->join('ojt_logs', 'ojt_logs.user_id = users.id', 'left')
            ->where('users.role', 'intern')
            ->group_by('users.id')
            ->order_by('users.id', 'DESC')
            ->get()->result_array();
        $data['intern_count'] = count($data['interns']);

        $hours_result = $this->db->select_sum('hours_rendered')->get('ojt_logs')->row();
        $data['total_hours'] = !empty($hours_result->hours_rendered) ? (float)$hours_result->hours_rendered : 0;
        $data['log_count'] = $this->db->count_all('ojt_logs');
        $data['pending_log_count'] = $this->db->where('status', 'Pending')->count_all_results('ojt_logs');
        $data['request_count'] = $this->db->like('subject', 'OJT Log Deletion Request')->where('is_read', 0)->count_all_results('messages');
        $data['pending_count'] = $data['pending_log_count'] + $data['request_count'];
        $data['active_count'] = $this->db->group_start()->where('status', 'active')->or_where('time_out IS NULL', NULL, FALSE)->group_end()->count_all_results('ojt_logs');
        $data['timed_out_count'] = max(0, $data['intern_count'] - $data['active_count']);
        $data['newly_approved_interns'] = $this->db
            ->where('role', 'intern')->where('account_status', 'approved')
            ->order_by('created_at', 'DESC')->limit(3)->get('users')->result_array();
        $data['interns_to_approve'] = $this->db
            ->where('role', 'intern')->where('account_status', 'pending')
            ->order_by('created_at', 'ASC')->limit(3)->get('users')->result_array();
        $data['required_hours'] = 500;
        $profile = $this->db->get_where('user_profile', array('id' => 1))->row_array();
        if (!empty($profile['required_hours'])) {
            $data['required_hours'] = (float)$profile['required_hours'];
        }

        $data['recent_logs'] = $this->db
            ->select('ojt_logs.*, users.first_name, users.last_name, users.email')
            ->from('ojt_logs')
            ->join('users', 'users.id = ojt_logs.user_id', 'left')
            ->order_by('ojt_logs.id', 'DESC')
            ->limit(30)
            ->get()->result_array();
        $data['requests'] = $this->db->like('subject', 'OJT Log Deletion Request')->order_by('id', 'DESC')->limit(3)->get('messages')->result_array();
        $data['latest_attendance'] = $data['recent_logs'];

        $data['departments'] = $this->db
            ->select('COALESCE(NULLIF(school, \'\'), \'Unassigned\') AS department, COUNT(*) AS intern_count')
            ->where('role', 'intern')
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

        $this->load->view('admin/dashboard', $data);
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
            'semester'      => trim($this->input->post('semester', TRUE))
        );

        if ($id <= 0 || empty($update_data['first_name']) || empty($update_data['last_name']) || !filter_var($update_data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Please provide a valid intern name and email.');
            redirect('admin');
            return;
        }

        $this->db->where('id', $id)->where('role', 'intern')->update('users', $update_data);
        $this->session->set_flashdata('success', 'Intern information updated successfully.');
        redirect('admin');
    }

    public function approve_intern($id) {
        if (!$this->require_admin()) {
            return;
        }

        $this->db->where('id', (int)$id)->where('role', 'intern')->update('users', array('account_status' => 'approved'));
        $this->session->set_flashdata('success', 'Intern account approved successfully.');
        redirect('admin');
    }

    public function update_log($id) {
        if (!$this->require_admin()) {
            return;
        }

        $id = (int)$id;
        $status = trim($this->input->post('status', TRUE));
        $allowed_statuses = array('active', 'Pending', 'Approved', 'Rejected', 'completed');
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
            redirect('admin');
            return;
        }

        $this->db->where('id', $id)->update('ojt_logs', $update_data);
        $this->session->set_flashdata('success', 'OJT record updated successfully.');
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
        redirect('admin');
    }

    public function mark_request_read($id) {
        if (!$this->require_admin()) {
            return;
        }

        $this->db->where('id', (int)$id)->update('messages', array('is_read' => 1));
        $this->session->set_flashdata('success', 'Deletion request marked as reviewed.');
        redirect('admin');
    }
}
