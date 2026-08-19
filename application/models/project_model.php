<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load database library if not autoloaded in application/config/autoload.php
        $this->load->database();
    }

    /**
     * Fetch all projects from the database.
     * Optionally pass a limit for home page featured sections.
     *
     * @param int|null $limit
     * @return array
     */
    public function get_all_projects($limit = NULL) {
        $this->db->order_by('created_at', 'DESC');
        if ($limit !== NULL) {
            $this->db->limit($limit);
        }
        $query = $this->db->get('projects');
        return $query->result_array();
    }

    /**
     * Fetch a single project by its URL slug (for frontend detail view).
     *
     * @param string $slug
     * @return array|null
     */
    public function get_project_by_slug($slug) {
        $query = $this->db->get_where('projects', array('slug' => $slug));
        return $query->row_array();
    }

    /**
     * Fetch a single project by its primary key ID (for admin edit/delete).
     *
     * @param int $id
     * @return array|null
     */
    public function get_project_by_id($id) {
        $query = $this->db->get_where('projects', array('id' => $id));
        return $query->row_array();
    }

    /**
     * Insert a new project into the database.
     *
     * @param array $data
     * @return bool|int Insert ID on success, false on failure
     */
    public function insert_project($data) {
        if ($this->db->insert('projects', $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * Update an existing project by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_project($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('projects', $data);
    }

    /**
     * Delete a project from the database by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_project($id) {
        $this->db->where('id', $id);
        return $this->db->delete('projects');
    }
}