<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ojt extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ojt_model');
    }

    public function index() {
        $rendered = $this->Ojt_model->get_total_rendered_hours();
        $required = $this->Ojt_model->get_required_hours();

        $data['page_title']     = 'OJT Hours Tracker | SDCA';
        $data['logs']           = $this->Ojt_model->get_all_logs();
        $data['rendered_hours'] = $rendered;
        $data['required_hours'] = $required;
        $data['remaining_hours']= max(0, $required - $rendered);
        $data['progress_pct']   = min(100, round(($rendered / $required) * 100, 1));

        $this->load->view('ojt_tracker', $data);
    }

    public function add_log() {
        $this->form_validation->set_rules('log_date', 'Date', 'required');
        $this->form_validation->set_rules('time_in', 'Time In', 'required');
        $this->form_validation->set_rules('time_out', 'Time Out', 'required');
        $this->form_validation->set_rules('task_summary', 'Tasks Done', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $time_in  = new DateTime($this->input->post('time_in'));
            $time_out = new DateTime($this->input->post('time_out'));
            $interval = $time_in->diff($time_out);
            
            // Calculate total decimal hours (minus 1 hour for lunch break if > 5 hrs)
            $hours = $interval->h + ($interval->i / 60);
            if ($hours >= 5) { $hours -= 1; }

            $logData = array(
                'log_date'       => $this->input->post('log_date'),
                'time_in'        => $this->input->post('time_in'),
                'time_out'       => $this->input->post('time_out'),
                'hours_rendered' => max(0, $hours),
                'task_summary'   => trim($this->input->post('task_summary', TRUE)),
                'status'         => 'Approved'
            );

            $this->Ojt_model->insert_log($logData);
            $this->session->set_flashdata('success', 'Time log recorded successfully!');
        }

        redirect('ojt');
    }

    public function update_log($id) {
        $this->form_validation->set_rules('log_date', 'Date', 'required');
        $this->form_validation->set_rules('time_in', 'Time In', 'required');
        $this->form_validation->set_rules('time_out', 'Time Out', 'required');
        $this->form_validation->set_rules('task_summary', 'Tasks Done', 'required|trim');
    
        if ($this->form_validation->run() == TRUE && is_numeric($id)) {
            $time_in  = new DateTime($this->input->post('time_in'));
            $time_out = new DateTime($this->input->post('time_out'));
            $interval = $time_in->diff($time_out);
            
            $hours = $interval->h + ($interval->i / 60);
            if ($hours >= 5) { $hours -= 1; }
    
            $logData = array(
                'log_date'       => $this->input->post('log_date'),
                'time_in'        => $this->input->post('time_in'),
                'time_out'       => $this->input->post('time_out'),
                'hours_rendered' => max(0, $hours),
                'task_summary'   => $this->input->post('task_summary', TRUE)
            );
    
            $this->Ojt_model->update_log($id, $logData);
            $this->session->set_flashdata('success', 'Log updated successfully!');
        }
    
        redirect('ojt');
    }

    public function delete_log($id) {
        $this->db->where('id', $id)->delete('ojt_logs');
        
        redirect('ojt');
    }
}