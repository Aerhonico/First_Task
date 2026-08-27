<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Ensure user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    // Handle Email Update Form
    public function update_email() {
        $new_email = $this->input->post('new_email');
        $user_id   = $this->session->userdata('user_id');

        if ($new_email) {
            $this->db->where('id', $user_id)->update('users', ['email' => $new_email]);
            $this->session->set_userdata('email', $new_email);
            $this->session->set_flashdata('success', 'Email updated successfully!');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    // Handle Password Update Form
    public function update_password() {
        $user_id      = $this->session->userdata('user_id');
        $new_password = $this->input->post('new_password');

        if ($new_password) {
            $hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $this->db->where('id', $user_id)->update('users', ['password' => $hashed]);
            $this->session->set_flashdata('success', 'Password updated successfully!');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    // Handle Personal Info Update Form
    public function update_info() {
        $user_id = $this->session->userdata('user_id');

        $update_data = [
            'first_name'    => $this->input->post('first_name'),
            'middle_name'   => $this->input->post('middle_name'),
            'last_name'     => $this->input->post('last_name'),
            'gender'        => $this->input->post('gender'),
            'birthday'      => $this->input->post('birthday'),
            'school'        => $this->input->post('school'),
            'year_section'  => $this->input->post('year_section'),
            'academic_year' => $this->input->post('academic_year'),
            'semester'      => $this->input->post('semester')
        ];

        $this->db->where('user_id', $user_id)->update('users', $update_data);
        $this->session->set_userdata($update_data);
        $this->session->set_flashdata('success', 'Information saved!');

        redirect($_SERVER['HTTP_REFERER']);
    }
}