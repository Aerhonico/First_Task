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
            redirect($this->session->userdata('role') === 'admin' ? 'admin' : 'ojt');
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
            redirect($this->session->userdata('role') === 'admin' ? 'admin' : 'ojt');
        }
        $this->load->view('admin/login');
    }

    // Show Intern Registration Form
    public function register() {
        $this->load->view('register');
    }

    // Process Intern Registration
    public function register_process() {
    $first_name  = trim($this->input->post('first_name', TRUE));
    $middle_name = trim($this->input->post('middle_name', TRUE));
    $last_name   = trim($this->input->post('last_name', TRUE));
    $email       = strtolower(trim($this->input->post('email', TRUE)));
    $password    = $this->input->post('password', TRUE);

    if (empty($first_name) || empty($last_name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->session->set_flashdata('error', 'Please provide your first name, last name, and a valid email address.');
        redirect('auth/register');
        return;
    }

    // 1. Check Password Requirements via Regex
    // Requires: >=8 chars, upper/lowercase, number, and special character
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    
    if (!preg_match($pattern, $password)) {
        $this->session->set_flashdata('error', 'Password does not meet the requirements.');
        redirect('auth/register');
        return;
    }

    // 2. Check if email already exists
    $this->db->group_start()
             ->where('email', $email)
             ->or_where('username', $email)
             ->group_end();
    $existing = $this->db->get('users')->row();
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
        'role'        => 'intern',
        'account_status' => 'pending'
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
        // 1. Check if user is currently locked out - TEMPORARILY DISABLED
        // $lockout_time = $this->session->userdata('lockout_time');
        // if ($lockout_time && time() < $lockout_time) {
        //     $seconds_left = $lockout_time - time();
        //     $minutes_left = ceil($seconds_left / 60);
        //     $this->session->set_flashdata('error', "Too many failed attempts. Try again in {$minutes_left} minute(s).");
        //     redirect('login');
        //     return;
        // }

        $identity = $this->input->post('username'); // Accepts either email or username input
        $password = $this->input->post('password');

        // Fetch user from database matching email OR username
        $this->db->group_start()
                 ->where('username', $identity)
                 ->or_where('email', $identity)
                 ->group_end();
        $user = $this->db->get('users')->row_array();

        // Check password (allows 'password123' bypass or valid hash)
        if ($user && password_verify($password, $user['password'])) {
            
            // SUCCESS: Clear lockout counters
            $this->session->unset_userdata('login_attempts');
            $this->session->unset_userdata('lockout_time');

            $role = !empty($user['role']) ? $user['role'] : 'intern';

            if ($role === 'intern' && isset($user['account_status']) && $user['account_status'] !== 'approved') {
                $this->session->set_flashdata('error', $user['account_status'] === 'pending' ? 'Your intern account is awaiting administrator approval.' : 'Your intern account is currently deactivated.');
                redirect('login');
                return;
            }

            $portal = trim($this->input->post('portal', TRUE));
            $portal = $portal === 'admin' ? 'admin' : 'intern';
            if (($portal === 'intern' && $role === 'admin') || ($portal === 'admin' && $role !== 'admin')) {
                $this->session->set_flashdata('error', $portal === 'admin' ? 'Only administrators can use the Admin Portal.' : 'Please use the Admin Portal Login for administrator access.');
                redirect($portal === 'admin' ? 'auth/admin_login' : 'login');
                return;
            }

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
                redirect('admin');
            } else {
                redirect('ojt');
            }

        } else {
            // FAILED ATTEMPT: Increment counter
            $attempts = $this->session->userdata('login_attempts') ? $this->session->userdata('login_attempts') : 0;
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);

            // TEMPORARILY DISABLED: 15-minute lockout
            // if ($attempts >= 5) {
            //     // Lock out for 15 minutes
            //     $this->session->set_userdata('lockout_time', time() + (15 * 60));
            //     $this->session->set_flashdata('error', 'Too many failed login attempts. Account locked for 15 minutes.');
            // } else {
            //     $remaining = 5 - $attempts;
            //     $this->session->set_flashdata('error', "Invalid Email/Username or Password. {$remaining} attempt(s) remaining.");
            // }

            $this->session->set_flashdata('error', 'Invalid Email/Username or Password.');

            redirect('login');
        }
    }

    public function forgot_password() {
        $this->load->view('auth/forgot_password', array(
            'reset_requested' => (bool)$this->session->userdata('reset_code_hash')
        ));
    }

    public function send_reset_code() {
        $is_ajax = $this->input->is_ajax_request();
        $email = strtolower(trim($this->input->post('email', TRUE)));
        $user = $this->db->get_where('users', array('email' => $email))->row_array();

        if (empty($user)) {
            if ($is_ajax) {
                echo json_encode(array('status' => 'success', 'message' => 'If an account exists for that email, a verification code has been sent.'));
                return;
            }
            $this->session->set_flashdata('success', 'If an account exists for that email, a verification code has been sent.');
            redirect('auth/forgot_password');
            return;
        }

        try {
            $code = (string)random_int(100000, 999999);
        } catch (Exception $exception) {
            $code = (string)mt_rand(100000, 999999);
        }

        $this->session->set_userdata(array(
            'reset_user_id'      => $user['id'],
            'reset_email'        => $email,
            'reset_code_hash'    => password_hash($code, PASSWORD_DEFAULT),
            'reset_code_expires' => time() + 600,
            'reset_code_attempts'=> 0
        ));

        $this->load->library('email', array(
            'protocol'     => 'smtp',
            'smtp_host'    => 'ssl://smtp.googlemail.com',
            'smtp_port'    => 465,
            'smtp_user'    => 'aerhonlouis_magtira@sdca.edu.ph',
            'smtp_pass'    => 'rbkz qpwo snyw pdnb',
            'mailtype'     => 'html',
            'charset'      => 'utf-8',
            'newline'      => "\r\n",
            'smtp_timeout' => 30
        ));
        $this->email->from('aerhonlouis_magtira@sdca.edu.ph', 'SDCA OJT Tracker');
        $this->email->to($email);
        $this->email->subject('SDCA OJT Tracker Password Reset Code');
        $this->email->message('<p>Your password reset verification code is:</p><h2>' . $code . '</h2><p>This code expires in 10 minutes. If you did not request this, you can ignore this email.</p>');

        if ($this->email->send()) {
            if ($is_ajax) {
                echo json_encode(array('status' => 'success', 'message' => 'A verification code was sent to your email.'));
                return;
            }
            $this->session->set_flashdata('success', 'A verification code was sent to your email.');
        } else {
            $this->session->unset_userdata(array('reset_user_id', 'reset_email', 'reset_code_hash', 'reset_code_expires', 'reset_code_attempts'));
            if ($is_ajax) {
                echo json_encode(array('status' => 'error', 'message' => 'The verification email could not be sent. Please try again later.'));
                return;
            }
            $this->session->set_flashdata('error', 'The verification email could not be sent. Please try again later.');
        }

        redirect('auth/forgot_password');
    }

    public function reset_password_process() {
        $is_ajax = $this->input->is_ajax_request();
        $user_id = $this->session->userdata('reset_user_id');
        $code = trim($this->input->post('verification_code', TRUE));
        $new_password = $this->input->post('new_password', TRUE);
        $confirm_password = $this->input->post('confirm_password', TRUE);
        $attempts = (int)$this->session->userdata('reset_code_attempts');

        if (empty($user_id) || empty($this->session->userdata('reset_code_hash')) || time() > (int)$this->session->userdata('reset_code_expires')) {
            if ($is_ajax) {
                echo json_encode(array('status' => 'error', 'message' => 'Your verification code has expired. Request a new code.'));
                return;
            }
            $this->session->set_flashdata('error', 'Your verification code has expired. Request a new code.');
            redirect('auth/forgot_password');
            return;
        }

        if ($attempts >= 5 || !password_verify($code, $this->session->userdata('reset_code_hash'))) {
            $attempts++;
            $this->session->set_userdata('reset_code_attempts', $attempts);
            if ($attempts >= 5) {
                $this->session->unset_userdata(array('reset_user_id', 'reset_email', 'reset_code_hash', 'reset_code_expires', 'reset_code_attempts'));
            }
            if ($is_ajax) {
                echo json_encode(array('status' => 'error', 'message' => 'Invalid verification code.'));
                return;
            }
            $this->session->set_flashdata('error', 'Invalid verification code.');
            redirect('auth/forgot_password');
            return;
        }

        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if ($new_password !== $confirm_password || !preg_match($password_pattern, $new_password)) {
            if ($is_ajax) {
                echo json_encode(array('status' => 'error', 'message' => 'Passwords must match and include at least 8 characters, uppercase, lowercase, number, and special character.'));
                return;
            }
            $this->session->set_flashdata('error', 'Passwords must match and include at least 8 characters, uppercase, lowercase, number, and special character.');
            redirect('auth/forgot_password');
            return;
        }

        $this->db->where('id', $user_id)->update('users', array('password' => password_hash($new_password, PASSWORD_BCRYPT)));
        $this->session->unset_userdata(array('reset_user_id', 'reset_email', 'reset_code_hash', 'reset_code_expires', 'reset_code_attempts'));
        if ($is_ajax) {
            echo json_encode(array('status' => 'success', 'message' => 'Password updated successfully. You can now log in.'));
            return;
        }
        $this->session->set_flashdata('success', 'Password updated successfully. You can now log in.');
        redirect('login');
    }

    // Logout Method
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}