<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->database();
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('auth/dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login_process() {
        // 1. Check if user is currently locked out
        $lockout_time = $this->session->userdata('lockout_time');
        if ($lockout_time && time() < $lockout_time) {
            $seconds_left = $lockout_time - time();
            $minutes_left = ceil($seconds_left / 60);
            $this->session->set_flashdata('error', "Too many failed attempts. Try again in {$minutes_left} minute(s).");
            redirect('login');
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Fetch user from database
        $user = $this->db->get_where('users', array('username' => $username))->row_array();
    
        // Check password (allows 'password123' or valid hash)
        if ($user && ($password === 'password123' || password_verify($password, $user['password']))) {
            
            // SUCCESS: Clear failed attempt counters
            $this->session->unset_userdata('login_attempts');
            $this->session->unset_userdata('lockout_time');

            $this->session->set_userdata(array(
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'logged_in' => TRUE
            ));
            redirect(''); // Redirects to main page

        } else {

            // FAILED: Increment attempt counter
            $attempts = $this->session->userdata('login_attempts') ? $this->session->userdata('login_attempts') : 0;
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);

            if ($attempts >= 5) {
                // Lock out for 15 minutes
                $this->session->set_userdata('lockout_time', time() + (15 * 60));
                $this->session->set_flashdata('error', 'Too many failed login attempts. Account locked for 15 minutes.');
            } else {
                $remaining = 5 - $attempts;
                $this->session->set_flashdata('error', "Invalid Username or Password. {$remaining} attempt(s) remaining.");
            }

            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('');
    }
    
    // Render the Forgot Password View
public function forgot_password() {
    $this->load->view('auth/forgot_password');
}

// Process the Password Reset
public function reset_password_process() {
    $username = $this->input->post('username');
    $new_password = $this->input->post('new_password');

    // Check if user exists
    $user = $this->db->get_where('users', array('username' => $username))->row_array();

    if ($user) {
        // Hash the new password securely
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update database
        $this->db->where('id', $user['id']);
        $this->db->update('users', array('password' => $hashed_password));

        // Reset lockout and attempts session data
        $this->session->unset_userdata('login_attempts');
        $this->session->unset_userdata('lockout_time');

        $this->session->set_flashdata('success', 'Password updated successfully! You can now log in.');
        redirect('login');
    } else {
        $this->session->set_flashdata('error', 'Username not found.');
        redirect('auth/forgot_password');
    }
}
}