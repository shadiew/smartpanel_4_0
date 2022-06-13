<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Get admin url
 * @param string slug to append (Optional)
 * @return url admin 
 */
if (!function_exists('admin_url')) {
    function admin_url($slug = "")
    {
        return PATH . 'admin/' . $slug;
    };
}

/**
 * Get client url
 * @param string slug to append (Optional)
 * @return url admin 
 */
if (!function_exists('client_url')) {
    function client_url($slug = "")
    {
        return PATH . $slug;
    };
}


/**
 * Is admin logged in
 * @return boolean
 */
if (!function_exists('is_admin_logged_in')) {
	function is_admin_logged_in()
    {
        if (session('uid') && get_role('admin')) {
            return true;
        }
		return false;
	}
}

/**
 * From V3.6
 * @return $string user role
 */
if (!function_exists('get_user_role')) {
    function get_user_role($uid = ""){
        if (!$uid) {
            $uid = session('uid');
        }
        $role = get_field(USERS, ['id' => $uid], "role");
        return $role;
    }
}

/**
 * @param string $role_type 
 * @return boolean 
 */
if(!function_exists('get_role')){
    function get_role($role_type = "", $id = ""){
        if (!session('uid')) {
            return false;
        }
        if(isset($GLOBALS['current_user']) && $GLOBALS['current_user']->role == $role_type){
            return true;
        }else{
            return false;
        }
    }
}

/**
 * @return array $data logged user information 
 */
if(!function_exists("current_logged_user")){
    function current_logged_user(){
        return $GLOBALS['current_user'];
    }
}


if(!function_exists("get_current_user_data")){
    function get_current_user_data($id = ""){
        if ($id == "") {
            $id = session("uid");
        }
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $user = $CI->help_model->get("*", USERS, ['id' => $id]);
        if(!empty($user)){
            return $user;
        }else{
            return false;
        }
    }
}

/*----------  Get user price  ----------*/
if (!function_exists('get_user_price')) {
    function get_user_price($uid, $service) {
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $user_price = $CI->help_model->get('service_price', USERS_PRICE, ['uid' => $uid, 'service_id' => $service->id]);
        if (isset($user_price->service_price)) {
            $price = $user_price->service_price;
        }else{
            $price = $service->price;
        }
        return $price;
    }
}