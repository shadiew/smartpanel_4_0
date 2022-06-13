<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppConfigModel extends CI_Model {
 
 protected $table;
 
    public function __construct() {
        $this->table = 'general_options';
    }
 
    public function get_configurations() {
        $query = $this->db->get($this->table);
        return $query->result();
 	}
}