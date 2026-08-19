<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ojt_model extends CI_Model {

    public function get_all_logs() {
        $this->db->order_by('log_date', 'DESC');
        return $this->db->get('ojt_logs')->result_array();
    }

    public function insert_log($data) {
        return $this->db->insert('ojt_logs', $data);
    }

    public function get_total_rendered_hours() {
        $this->db->select_sum('hours_rendered');
        $query = $this->db->get('ojt_logs');
        $result = $query->row();
        return $result->hours_rendered ? $result->hours_rendered : 0;
    }

    public function get_required_hours() {
        $query = $this->db->get('ojt_settings')->row();
        return $query ? $query->required_hours : 500;
    }

    public function update_log($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('ojt_logs', $data);
    }
}