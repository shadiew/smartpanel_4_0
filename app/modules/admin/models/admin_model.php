<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_model extends MY_Model 
{
    protected $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = USERS;
    }

    public function save_item($params = null, $option = null)
    {
        switch ($option['task']) {
            case 'update-info-item':
                $data = array(
                    "first_name"   => post("first_name"),
                    "last_name"    => post("last_name"),
                    "timezone"     => post("timezone"),
                );
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-pass-item':
                $data = [
                    'password' => $this->app_password_hash(post('password')),
                    'changed'  => NOW,
                ];
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Password changed successfully!'];
                break;
        }
    }
}
