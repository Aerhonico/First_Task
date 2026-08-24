<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load helpers, libraries, and models
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->model('Project_model');
    }

    /**
     * Renders the portfolio home page
     */
    public function index() {
        $data['page_title'] = 'My Portfolio | First task';
        
        // Fetch projects from MySQL using Project_model
        $data['projects'] = $this->Project_model->get_all_projects();

        // Fetch certifications
        $data['certifications'] = $this->db->get('certifications')->result_array();

        // Get profile details from user_profile table
        $data['hero'] = $this->db->get_where('user_profile', array('id' => 1))->row_array(); 

        // Get user account details from users table
        $data['user'] = $this->db->get_where('users', array('id' => 1))->row_array(); 

        // Load the Bootstrap 5 view and pass all data once
        $this->load->view('home', $data);
    }

    public function send_message() {
        $name    = $this->input->post('name');
        $email   = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        // SMTP Configuration
        $config = array(
            'protocol'     => 'smtp',
            'smtp_host'    => 'ssl://smtp.googlemail.com',
            'smtp_port'    => 465,
            'smtp_user'    => 'aerhonlouis_magtira@sdca.edu.ph',
            'smtp_pass'    => 'rbkz qpwo snyw pdnb', // App Password
            'mailtype'     => 'html',
            'charset'      => 'utf-8',
            'newline'      => "\r\n",
            'smtp_timeout' => 30
        );

        $this->load->library('email', $config);

        $this->email->from('aerhonlouismagtira@gmail.com', $name);
        $this->email->to('aerhonlouis_magtira@sdca.edu.ph'); // Destination email
        $this->email->reply_to($email, $name);
        $this->email->subject('Portfolio Inquiry: ' . $subject);
        
        $body = "<h3>New Inquiry from Portfolio Website</h3>";
        $body .= "<p><strong>Name:</strong> {$name}</p>";
        $body .= "<p><strong>Email:</strong> {$email}</p>";
        $body .= "<p><strong>Message:</strong><br>{$message}</p>";

        $this->email->message($body);

        if ($this->email->send()) {
            $this->session->set_flashdata('contact_success', 'Your message has been sent successfully!');
        } else {
            // Echo debug info if sending fails
            show_error($this->email->print_debugger());
            return;
        }

        redirect('#contact');
    }

    /**
     * Updates Hero section profile details
     */
    public function update_hero() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }
    
        $full_name = $this->input->post('full_name');
        $bio       = $this->input->post('bio');
    
        $update_data = array(
            'full_name' => $full_name,
            'bio'       => $bio
        );
    
        // Handle Profile Picture Upload
        if (!empty($_FILES['profile_img']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'profile_' . time();
    
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('profile_img')) {
                $upload_data = $this->upload->data();
                $update_data['profile_img'] = $upload_data['file_name'];
            }
        }
    
        // Force update row ID 1 in user_profile
        $this->db->where('id', 1);
        $this->db->update('user_profile', $update_data);
    
        $this->session->set_flashdata('hero_success', 'Hero section updated successfully!');
        redirect(''); // Refresh page
    }

    public function add_project() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }
    
        $title       = $this->input->post('title');
        $description = $this->input->post('description');
        $tech_stack  = $this->input->post('tech_stack');
        $image_name  = 'default_project.jpg';
    
        // Handle Image Upload
        if (!empty($_FILES['project_img']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'proj_' . time();
    
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('project_img')) {
                $upload_data = $this->upload->data();
                $image_name  = $upload_data['file_name'];
            }
        }
    
        $project_data = array(
            'title'       => $title,
            'description' => $description,
            'tech_stack'  => $tech_stack,
            'image'       => $image_name,
            'created_at'  => date('Y-m-d H:i:s')
        );
    
        $this->db->insert('projects', $project_data);
    
        $this->session->set_flashdata('project_success', 'New project added successfully!');
        redirect(''); // Refresh page
    }

}