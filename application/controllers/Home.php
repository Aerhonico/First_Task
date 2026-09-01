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

    // Fetch the 50 most recent activity logs for admin view
    $data['logs'] = $this->db->order_by('id', 'DESC')->limit(50)->get('activity_logs')->result_array();

    // Fetch tech stack items categorized by their type
    $data['tech_stack'] = $this->db->get('tech_stack')->result_array();

    // Generate Math CAPTCHA Question
    $n1 = rand(1, 9);
    $n2 = rand(1, 9);
    $this->session->set_userdata('math_captcha_ans', $n1 + $n2);
    $data['math_question'] = "{$n1} + {$n2}";

    // Set form load timestamp BEFORE rendering the view
    $this->session->set_userdata('form_load_time', time());
    
    // Load the view LAST
    $this->load->view('home', $data);
}

public function send_message() {
    
    // Helper para sa panibagong Math CAPTCHA question
    $n1 = rand(1, 9);
    $n2 = rand(1, 9);
    $this->session->set_userdata('math_captcha_ans', $n1 + $n2);
    $new_question = "{$n1} + {$n2}";

    // 1. HONEYPOT CHECK
    if (!empty($this->input->post('website_hp'))) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Your message has been sent successfully!',
            'new_math_question' => $new_question
        ]);
        return;
    }

    // 2. TIME-BASED SPAM CHECK
    $load_time = $this->session->userdata('form_load_time');
    $submit_time = time();

    if ($load_time && ($submit_time - $load_time) < 3) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Form submitted too fast. Please wait a moment and try again.',
            'new_math_question' => $new_question
        ]);
        return;
    }

    // 3. MATH CAPTCHA CHECK
    $user_math_ans = (int)$this->input->post('math_answer');
    $session_math_ans = (int)$this->session->userdata('math_captcha_ans');

    if ($user_math_ans !== $session_math_ans) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Incorrect security answer. Please try again.',
            'new_math_question' => $new_question
        ]);
        return;
    }

    // PROCESS FORM DATA
    $name    = trim($this->input->post('name', TRUE));
    $email   = trim($this->input->post('email', TRUE));
    $subject = trim($this->input->post('subject', TRUE));
    $message = trim($this->input->post('message', TRUE));

    // SMTP Configuration
    $config = array(
        'protocol'     => 'smtp',
        'smtp_host'    => 'ssl://smtp.googlemail.com',
        'smtp_port'    => 465,
        'smtp_user'    => 'aerhonlouis_magtira@sdca.edu.ph',
        'smtp_pass'    => 'rbkz qpwo snyw pdnb',
        'mailtype'     => 'html',
        'charset'      => 'utf-8',
        'newline'      => "\r\n",
        'smtp_timeout' => 30
    );

    $this->load->library('email', $config);

    $this->email->from('aerhonlouismagtira@gmail.com', $name);
    $this->email->to('aerhonlouis_magtira@sdca.edu.ph');
    $this->email->reply_to($email, $name);
    $this->email->subject('Portfolio Inquiry: ' . $subject);
    
    $body  = "<h3>New Inquiry from Portfolio Website</h3>";
    $body .= "<p><strong>Name:</strong> {$name}</p>";
    $body .= "<p><strong>Email:</strong> {$email}</p>";
    $body .= "<p><strong>Message:</strong><br>{$message}</p>";

    $this->email->message($body);

    if ($this->email->send()) {
        $this->log_activity('Sent Message', 'Contact', 'Inquiry sent by: ' . $email);
        echo json_encode([
            'status' => 'success', 
            'message' => 'Your message has been sent successfully!',
            'new_math_question' => $new_question
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Failed to send email. Please try again later.',
            'new_math_question' => $new_question
        ]);
    }
}

    /**
     * Updates Hero section profile details
     */
    public function update_hero() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }
    
        $full_name = trim($this->input->post('full_name', TRUE));
        $bio       = trim($this->input->post('bio', TRUE));
    
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
    
        // LOG BEFORE REDIRECT
        $this->log_activity('Updated', 'Hero Section', 'Updated bio and name for ' . $full_name);
        $this->session->set_flashdata('hero_success', 'Hero section updated successfully!');
        redirect('');
    }

    public function add_project() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        if (empty($_FILES['project_img']['name'])) {
            die('DEBUG ERROR: $_FILES["project_img"] is empty.');
        }

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
            $title       = trim($this->input->post('title', TRUE));

            $project_data = array(
                'title'       => $title,
                'description' => trim($this->input->post('description', TRUE)),
                'tech_stack'  => trim($this->input->post('tech_stack', TRUE)),
                'project_img' => $image_name,
                'created_at'  => date('Y-m-d H:i:s')
            );

            $this->db->insert('projects', $project_data);

            // LOG BEFORE REDIRECT OR DIE
            $this->log_activity('Added', 'Projects', 'Added project: ' . $title);
            $this->session->set_flashdata('project_success', 'Project added successfully!');
            redirect('');
        } else {
            die('CI UPLOAD ERROR: ' . $this->upload->display_errors());
        }
    }

    public function edit_project($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        $title = trim($this->input->post('title', TRUE));
        $update_data = array(
            'title'       => $title,
            'description' => trim($this->input->post('description', TRUE)),
            'tech_stack'  => trim($this->input->post('tech_stack', TRUE))
        );

        if (!empty($_FILES['project_img']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'proj_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('project_img')) {
                $upload_data = $this->upload->data();
                $update_data['project_img'] = $upload_data['file_name'];
            }
        }

        $this->db->where('id', $id);
        $this->db->update('projects', $update_data);

        // LOG BEFORE REDIRECT
        $this->log_activity('Updated', 'Projects', 'Updated project: ' . $title);
        $this->session->set_flashdata('project_success', 'Project updated successfully!');
        redirect('');
    }

    public function delete_project($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            } else {
                redirect('login');
            }
            return;
        }

        $this->db->where('id', $id);
        $this->db->delete('projects');

        // LOG BEFORE RESPONSE
        $this->log_activity('Deleted', 'Projects', 'Deleted project ID: ' . $id);

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => 'Project deleted successfully']);
        } else {
            $this->session->set_flashdata('project_success', 'Project deleted successfully!');
            redirect('');
        }
    }

    public function update_project_order() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }

        // Get the JSON input
        $input = json_decode(file_get_contents('php://input'), TRUE);
        
        if (!isset($input['projects']) || !is_array($input['projects'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid project data']);
            return;
        }

        // Update each project's display_order
        foreach ($input['projects'] as $project) {
            $this->db->where('id', (int)$project['id']);
            $this->db->update('projects', ['display_order' => (int)$project['order']]);
        }

        $this->log_activity('Updated', 'Projects', 'Reordered projects via drag-and-drop');
        echo json_encode(['status' => 'success', 'message' => 'Project order updated']);
    }

    public function update_project_details($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        $update_data = array(
            'about_project' => trim($this->input->post('about_project', TRUE)),
            'site_url'      => trim($this->input->post('site_url', TRUE))
        );

        $existing = $this->db->get_where('projects', array('id' => $id))->row_array();
        $gallery_list = !empty($existing['gallery_images']) ? explode(',', $existing['gallery_images']) : array();

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

        // LOG BEFORE REDIRECT
        $this->log_activity('Updated Details', 'Projects', 'Updated extended details for project ID: ' . $id);
        $this->session->set_flashdata('project_success', 'Project details updated successfully!');
        redirect('');
    }

    public function add_tech_stack() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        $name = trim($this->input->post('name', TRUE));
        $data = array(
            'name'     => $name,
            'icon'     => trim($this->input->post('icon', TRUE)),
            'category' => trim($this->input->post('category', TRUE))
        );

        $this->db->insert('tech_stack', $data);

        // LOG BEFORE REDIRECT
        $this->log_activity('Added', 'Tech Stack', 'Added skill: ' . $name);
        $this->session->set_flashdata('project_success', 'Tech stack item added successfully!');
        redirect('');
    }

    public function delete_tech_stack($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        $this->db->where('id', $id);
        $this->db->delete('tech_stack');

        // LOG BEFORE REDIRECT
        $this->log_activity('Deleted', 'Tech Stack', 'Removed tech item ID: ' . $id);
        $this->session->set_flashdata('project_success', 'Item removed successfully!');
        redirect('');
    }

    public function add_certification() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('login');
            return;
        }

        $badge_img = 'default-cert.png';
        $cert_image = 'default-cert.jpg';

        if (!empty($_FILES['badge_img']['name'])) {
            $config['upload_path']   = FCPATH . 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'badge_' . time();

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('badge_img')) {
                $uploadData = $this->upload->data();
                $badge_img  = $uploadData['file_name'];
            }
        }

        if (!empty($_FILES['cert_image']['name'])) {
            $config['upload_path']   = FCPATH . 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = 'cert_' . time();

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('cert_image')) {
                $uploadData  = $this->upload->data();
                $cert_image = $uploadData['file_name'];
            }
        }

        $title = trim($this->input->post('title', TRUE));
        $data = array(
            'title'      => $title,
            'issuer'     => trim($this->input->post('issuer', TRUE)),
            'issue_date' => trim($this->input->post('issue_date', TRUE)),
            'badge_img'  => $badge_img,
            'cert_image' => $cert_image
        );

        $this->db->insert('certifications', $data);

        // LOG BEFORE REDIRECT
        $this->log_activity('Added', 'Certifications', 'Title: ' . $title);
        $this->session->set_flashdata('project_success', 'Certification added successfully!');
        redirect('');
    }

    public function delete_certification($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            } else {
                redirect('login');
            }
            return;
        }

        $this->db->where('id', $id);
        $this->db->delete('certifications');

        // LOG BEFORE RESPONSE
        $this->log_activity('Deleted', 'Certifications', 'Deleted cert ID: ' . $id);

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => 'Certification deleted successfully']);
        } else {
            $this->session->set_flashdata('project_success', 'Certification deleted successfully!');
            redirect('');
        }
    }

    private function log_activity($action, $section, $details = '') {
        $log_data = array(
            'user_id'    => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : NULL,
            'section'    => $section,
            'action'     => $action,
            'details'    => $details,
            'ip_address' => $this->input->ip_address()
        );
        $this->db->insert('activity_logs', $log_data);
    }

}