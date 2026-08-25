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

        // 1. Check raw file data
        if (empty($_FILES['project_img']['name'])) {
            die('DEBUG ERROR: $_FILES["project_img"] is empty. Check <form enctype="multipart/form-data"> and <input name="project_img">.');
        }

        // 2. Setup upload directory path
        $upload_path = FCPATH . 'assets/images/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = '*';
        $config['file_name']     = 'proj_' . time();

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('project_img')) {
            $upload_data = $this->upload->data();
            $image_name  = $upload_data['file_name'];

            $project_data = array(
                'title'       => trim($this->input->post('title', TRUE)),
                'description' => trim($this->input->post('description', TRUE)),
                'tech_stack'  => trim($this->input->post('tech_stack', TRUE)),
                'project_img' => $image_name,
                'created_at'  => date('Y-m-d H:i:s')
            );

            $this->db->insert('projects', $project_data);

            // DIE WITH SUCCESS INFO TO VERIFY DB AND FILE SAVED
            die('SUCCESS: Uploaded file saved as ' . $image_name . ' in ' . $upload_path);
        } else {
            die('CI UPLOAD ERROR: ' . $this->upload->display_errors());
        }
    }

    public function edit_project($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $update_data = array(
            'title'       => trim($this->input->post('title', TRUE)),
            'description' => trim($this->input->post('description', TRUE)),
            'tech_stack'  => trim($this->input->post('tech_stack', TRUE))
        );

        // If a new image was uploaded
        if (!empty($_FILES['project_img']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'proj_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('project_img')) {
                $upload_data = $this->upload->data();
                // Match database column name 'project_img'
                $update_data['project_img'] = $upload_data['file_name'];
            }
        }

        $this->db->where('id', $id);
        $this->db->update('projects', $update_data);

        $this->session->set_flashdata('project_success', 'Project updated successfully!');
        redirect('');
        // Inside edit_project() or update_project_details():
        $this->session->set_flashdata('project_success', 'Project updated successfully!');
        redirect('');
    }

    // Delete Project Action
    public function delete_project($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $this->db->where('id', $id);
        $this->db->delete('projects');

        $this->session->set_flashdata('project_success', 'Project deleted successfully!');
        redirect('');
    }

    public function update_project_details($id) {
    if (!$this->session->userdata('logged_in')) {
        redirect('login');
        return;
    }

    $update_data = array(
        'about_project' => trim($this->input->post('about_project', TRUE)),
        'site_url'      => trim($this->input->post('site_url', TRUE))
    );

    // Fetch current project to manage existing gallery images
    $existing = $this->db->get_where('projects', array('id' => $id))->row_array();
    $gallery_list = !empty($existing['gallery_images']) ? explode(',', $existing['gallery_images']) : array();

    // Handle Multiple Carousel Image Uploads
    if (!empty($_FILES['carousel_images']['name'][0])) {
        $filesCount = count($_FILES['carousel_images']['name']);
        
        $config['upload_path']   = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';

        $this->load->library('upload');

        for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['file']['name']     = $_FILES['carousel_images']['name'][$i];
            $_FILES['file']['type']     = $_FILES['carousel_images']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['carousel_images']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['carousel_images']['error'][$i];
            $_FILES['file']['size']     = $_FILES['carousel_images']['size'][$i];

            $config['file_name'] = 'gallery_' . time() . '_' . $i;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $gallery_list[] = $uploadData['file_name'];
            }
        }
        $update_data['gallery_images'] = implode(',', $gallery_list);
    }

    $this->db->where('id', $id);
    $this->db->update('projects', $update_data);

    $this->session->set_flashdata('project_success', 'Project details updated successfully!');
    redirect('');
}

}