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

    public function ensure_support_tables() {
        $this->db->query('CREATE TABLE IF NOT EXISTS intern_documents (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            document_type VARCHAR(100) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            original_name VARCHAR(255) NOT NULL,
            status ENUM("Pending", "Verified", "Rejected") NOT NULL DEFAULT "Pending",
            uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY intern_document_type (user_id, document_type)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->db->query('CREATE TABLE IF NOT EXISTS intern_inquiries (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            category VARCHAR(100) NOT NULL,
            message TEXT NOT NULL,
            admin_reply TEXT NULL,
            status ENUM("Open", "Answered", "Closed") NOT NULL DEFAULT "Open",
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            replied_at DATETIME NULL DEFAULT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->db->query('CREATE TABLE IF NOT EXISTS announcement_reads (
            user_id INT NOT NULL,
            announcement_id INT NOT NULL,
            read_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (user_id, announcement_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    }

    public function get_documents($user_id) {
        return $this->db->where('user_id', (int)$user_id)
            ->order_by('document_type', 'ASC')
            ->get('intern_documents')->result_array();
    }

    public function save_document($user_id, $document_type, $file_path, $original_name) {
        $data = array(
            'user_id' => (int)$user_id,
            'document_type' => $document_type,
            'file_path' => $file_path,
            'original_name' => $original_name,
            'status' => 'Pending'
        );

        $existing = $this->db->where('user_id', (int)$user_id)->where('document_type', $document_type)->get('intern_documents')->row_array();
        if (!empty($existing)) {
            return $this->db->where('id', $existing['id'])->update('intern_documents', $data);
        }

        return $this->db->insert('intern_documents', $data);
    }

    public function create_inquiry($user_id, $category, $message) {
        return $this->db->insert('intern_inquiries', array(
            'user_id' => (int)$user_id,
            'category' => $category,
            'message' => $message
        ));
    }

    public function get_inquiries($user_id) {
        return $this->db->where('user_id', (int)$user_id)
            ->order_by('created_at', 'DESC')
            ->get('intern_inquiries')->result_array();
    }

    public function get_all_inquiries() {
        return $this->db->select('intern_inquiries.*, users.first_name, users.last_name, users.email')
            ->from('intern_inquiries')
            ->join('users', 'users.id = intern_inquiries.user_id', 'left')
            ->order_by('intern_inquiries.created_at', 'DESC')
            ->get()->result_array();
    }

    public function reply_to_inquiry($inquiry_id, $reply) {
        return $this->db->where('id', (int)$inquiry_id)->update('intern_inquiries', array(
            'admin_reply' => $reply,
            'status' => 'Answered',
            'replied_at' => date('Y-m-d H:i:s')
        ));
    }
}