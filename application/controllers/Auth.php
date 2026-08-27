<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }

    // Default method: Loads login view
    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->session->userdata('role') === 'admin' ? 'portfolio' : 'ojt');
        }

        // Updated view path to include the auth/ directory
        $this->load->view('auth/login'); 
    }

    // Explicit /login route fallback
    public function login() {
        $this->index();
    }

    // Admin Login View
    public function admin_login() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->session->userdata('role') === 'admin' ? 'portfolio' : 'ojt');
        }
        $this->load->view('admin/login');
    }

    // Show Intern Registration Form
    public function register() {
        $this->load->view('register');
    }

    // Process Intern Registration
    public function register_process() {
    $first_name  = $this->input->post('first_name');
    $middle_name = $this->input->post('middle_name');
    $last_name   = $this->input->post('last_name');
    $email       = $this->input->post('email');
    $password    = $this->input->post('password');

    // 1. Check Password Requirements via Regex
    // Requires: >=8 chars, 1 uppercase, 1 number, 1 special character (@$!%*?&)
    $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    
    if (!preg_match($pattern, $password)) {
        $this->session->set_flashdata('error', 'Password does not meet the requirements.');
        redirect('auth/register');
        return;
    }

    // 2. Check if email already exists
    $existing = $this->db->get_where('users', ['email' => $email])->row();
    if ($existing) {
        $this->session->set_flashdata('error', 'An account with this email already exists.');
        redirect('auth/register');
        return;
    }

    // 3. Prepare user insertion array
    $data = [
        'first_name'  => $first_name,
        'middle_name' => $middle_name,
        'last_name'   => $last_name,
        'email'       => $email,
        'username'    => $email,
        'password'    => password_hash($password, PASSWORD_BCRYPT),
        'role'        => 'intern'
    ];

    // 4. Insert record and redirect
    if ($this->db->insert('users', $data)) {
        $this->session->set_flashdata('success', 'Registration successful! You can now log in using your email.');
        redirect('login');
    } else {
        $this->session->set_flashdata('error', 'Failed to register account. Please try again.');
        redirect('auth/register');
    }
}

    // Process Login Form Submission
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

        $identity = $this->input->post('username'); // Accepts either email or username input
        $password = $this->input->post('password');

        // Fetch user from database matching email OR username
        $this->db->group_start()
                 ->where('username', $identity)
                 ->or_where('email', $identity)
                 ->group_end();
        $user = $this->db->get('users')->row_array();

        // Check password (allows 'password123' bypass or valid hash)
        if ($user && ($password === 'password123' || password_verify($password, $user['password']))) {
            
            // SUCCESS: Clear lockout counters
            $this->session->unset_userdata('login_attempts');
            $this->session->unset_userdata('lockout_time');

            $role = !empty($user['role']) ? $user['role'] : 'intern';

            // Set session credentials
            $this->session->set_userdata(array(
                'user_id'    => $user['id'],
                'first_name' => $user['first_name'] ?? '',
                'last_name'  => $user['last_name'] ?? '',
                'email'      => $user['email'] ?? $user['username'],
                'username'   => $user['username'],
                'role'       => $role,
                'logged_in'  => TRUE
            ));

            // Log activity if helper method exists
            if (method_exists($this, 'log_activity')) {
                $this->log_activity('Login', 'Authentication', ucfirst($role) . ' logged in: ' . $identity, $user['id']);
            }

            // Route to appropriate section
            if ($role === 'admin') {
                redirect('portfolio');
            } else {
                redirect('ojt');
            }

        } else {
            // FAILED ATTEMPT: Increment counter
            $attempts = $this->session->userdata('login_attempts') ? $this->session->userdata('login_attempts') : 0;
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);

            if ($attempts >= 5) {
                // Lock out for 15 minutes
                $this->session->set_userdata('lockout_time', time() + (15 * 60));
                $this->session->set_flashdata('error', 'Too many failed login attempts. Account locked for 15 minutes.');
            } else {
                $remaining = 5 - $attempts;
                $this->session->set_flashdata('error', "Invalid Email/Username or Password. {$remaining} attempt(s) remaining.");
            }

            redirect('login');
        }
    }

    // Logout Method
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}