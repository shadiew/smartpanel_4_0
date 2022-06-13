<?php
class AppSettingClass {

    function GetAppSetting() {
        $CI = &get_instance();
        $CI->load->database();
        $CI->db->select('name, value');
		$CI->db->from('general_options');
		$query = $CI->db->get();
        $result = $query->result_array();
        if($result){
            $result = array_column($result, 'value', 'name');
            // store in $GLOBALS
            $GLOBALS['app_settings'] = $result;
        }

        // Get User Information
        if(session('uid')){
            $user = null;
            $CI->db->select('*');
            $CI->db->from(USERS);
            $CI->db->where('id', session('uid'));
            $query = $CI->db->get();
            $user = $query->row();
            if($user){
                $GLOBALS['current_user'] = $user;
            }
        }
    }

}