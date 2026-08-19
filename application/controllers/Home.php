<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the model to handle database queries
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

        // Load the Bootstrap 5 view and pass data
        $this->load->view('home', $data);
    }

    /**
     * Processes the contact form submission
     */
    public function send_message() {
        // Set form validation rules
        $this->form_validation->set_rules('sender_name', 'Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('sender_email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('message_text', 'Message', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed — reload the homepage with error messages
            $this->index();
        } else {
            // Validation passed — save contact message to database
            $formData = array(
                'sender_name'  => $this->input->post('sender_name', TRUE),
                'sender_email' => $this->input->post('sender_email', TRUE),
                'subject'      => $this->input->post('subject', TRUE),
                'message_text' => $this->input->post('message_text', TRUE),
                'created_at'   => date('Y-m-d H:i:s')
            );

            // Insert into 'messages' table (if created) or display success
            $this->db->insert('messages', $formData);

            $this->session->set_flashdata('success', 'Thank you! Your message has been sent successfully.');
            redirect('home#contact');
        }
    }
}