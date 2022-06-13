<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * From V3.6
 * Check unique on update/edit
 * $input_filed
 * $params [table.field.id]
 */
if (!function_exists('edit_unique')) {
    function edit_unique($input_field, $params)  {
        $CI =& get_instance();
        $CI->load->database();
        $CI->form_validation->set_message('edit_unique', "The %s already exists.");
        list($table, $field, $current_id) = explode(".", $params);
        $query = $CI->db->select()->from($table)->where($field, $input_field)->limit(1)->get();
        $item = $query->row();
        if ($item && $item->id != $current_id)
        {
            //ids case
            if (isset($item->ids) && $item->ids == $current_id) {
                return TRUE; 
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

/**
 * From V3.6
 * Validate Funds input
 * $input_fund
 */
if (!function_exists('validate_money')) {
    function validate_money($input_fund)  {
        $CI =& get_instance();
        $CI->load->database();
        $CI->form_validation->set_message('validate_money', "The %s you entered is invalid");
        if(preg_match('/^[0-9]*\.?[0-9]+$/', $input_fund)){
            return true;
        } else {
            return false;
        }
    }
}