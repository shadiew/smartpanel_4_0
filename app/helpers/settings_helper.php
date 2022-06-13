<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if(!function_exists("delete_option")){
    function delete_option($key){
        $CI = &get_instance();
        $CI->db->delete(OPTIONS, array("name" => $key));
    }
}

/**
 *
 * Get option and update option
 *
 */
if (!function_exists("get_option")) {
    function get_option($key, $value = "")
    {
        // check data from $GLOBALS
        if (isset($GLOBALS['app_settings'][$key])) {
            return $GLOBALS['app_settings'][$key];
        }
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }
        $option = $CI->help_model->get("value", OPTIONS, "name = '{$key}'");
        if (empty($option)) {
            $CI->db->insert(OPTIONS, array("name" => $key, "value" => $value));
            return $value;
        } else {
            return $option->value;
        }
    }
}

if (!function_exists("update_option")) {
    function update_option($key, $value)
    {
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }

        $option = $CI->help_model->get("value", OPTIONS, "name = '{$key}'");
        if (empty($option)) {
            $CI->db->insert(OPTIONS, array("name" => $key, "value" => $value));
        } else {
            $CI->db->update(OPTIONS, array("value" => $value), array("name" => $key));
        }
    }
}