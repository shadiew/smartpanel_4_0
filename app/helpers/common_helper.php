<?php

if (!function_exists('post_get')) {
    function post_get($name = "")
    {
        $CI = &get_instance();
        if ($name != "") {
            return $CI->input->post_get(trim($name));
        } else {
            return $CI->input->post_get();
        }
    }
}

if (!function_exists('get')) {
    function get($name = "")
    {
        $CI = &get_instance();
        $CI->load->library("security");
        $result = trim($CI->input->get($name));
        $result = $CI->security->xss_clean($result);
        $result = strip_tags($result);
        $result = html_entity_decode($result);
        $result = urldecode($result);
        $result = addslashes($result);
        return $result;
    }
}

if (!function_exists('post')) {
    function post($name = "")
    {
        $CI = &get_instance();
        if ($name != "") {
            $post = $CI->input->post($name);
            if (is_string($post)) {
                $result = trim($CI->input->post(trim($name)));
                $result = addslashes($result);
                $result = strip_tags($result);
            } else {
                $result = $post;
            }
            return $result;
        } else {
            return $CI->input->post();
        }
    }
}

function xss_clean($data)
{
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}

if (!function_exists('get_configs')) {
    function get_configs($params)
    {
        $CI = &get_instance();
        $CI->load->config('config');
        $value = $CI->config->item($params);
        return $value;
    }
}

/**
 * Update configure file
 * @param $key, $value, $filename
 * @return mixed
 */
if (!function_exists('update_configs')) {
    function update_configs($params = [])
    {
        if (!isset($params['filename'])) {
            $filename = 'app_configs';
        }
        $CI = &get_instance();
        $CI->load->config($filename);
        $item = $CI->config->set_item($params['slug'], $params['value']);
    }
}

/**
 * Get Value from JSone string
 * @param $dataJson, $key
 * @return index of key
 */
if (!function_exists('get_value')) {
    function get_value($dataJson, $key, $parseArray = false, $return = false)
    {
        if (is_string($dataJson)) {
            $dataJson = json_decode($dataJson);
        }

        if (is_object($dataJson)) {
            if (isset($dataJson->$key)) {
                if ($parseArray) {
                    return (array) $dataJson->$key;
                } else {
                    return $dataJson->$key;
                }
            }
        } else if (is_array($dataJson)) {
            if (isset($dataJson[$key])) {
                return $dataJson[$key];
            }
        } else {
            return $dataJson;
        }

        return $return;
    }
}

if (!function_exists('get_secure')) {
    function get_secure($name = "")
    {
        $CI = &get_instance();
        return filter_input_xss($CI->input->get(trim($name)));
    }
}

if (!function_exists('remove_empty_value')) {
    function remove_empty_value($data)
    {
        if (!empty($data)) {
            return array_filter($data, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
        } else {
            return false;
        }
    }
}

if (!function_exists('get_random_value')) {
    function get_random_value($data)
    {
        if (is_array($data) && !empty($data)) {
            $index = array_rand($data);
            return $data[$index];
        } else {
            return false;
        }
    }
}

if (!function_exists('get_random_values')) {
    function get_random_values($data, $limit)
    {
        if (is_array($data) && !empty($data)) {
            shuffle($data);
            if (count($data) < $limit) {
                $limit = count($data);
            }

            return array_slice($data, 0, $limit);
        } else {
            return false;
        }
    }
}

if (!function_exists('specialchar_decode')) {
    function specialchar_decode($input)
    {
        $input = str_replace("\\'", "'", $input);
        $input = str_replace('\"', '"', $input);
        $input = htmlspecialchars_decode($input, ENT_QUOTES);
        return $input;
    }
}

if (!function_exists('filter_input_xss')) {
    function filter_input_xss($input)
    {
        $input = htmlspecialchars($input, ENT_QUOTES);
        return $input;
    }
}

if (!function_exists('ms')) {
    function ms($array)
    {
        print_r(json_encode($array));
        exit(0);
    }
}

/**
 * @param string $status error/success
 * @param string $message
 * @return Print Message
 */
if (!function_exists('_validation')) {
    function _validation($status, $ms)
    {
        ms(['status' => $status, 'message' => $ms]);
    }
}

if (!function_exists('get_json_content')) {
    function get_json_content($path, $data = [])
    {
        if ($data) {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            return json_decode(file_get_contents($path . '?' . http_build_query($data), false, stream_context_create($arrContextOptions)));
        } else {
            if (file_exists($path)) {
                return json_decode(file_get_contents($path));
            } else {
                return false;
            }
        }
    }
}

if (!function_exists('ids')) {
    function ids()
    {
        $CI = &get_instance();
        return md5($CI->encryption->encrypt(time()));
    };
}

if (!function_exists('session')) {
    function session($input)
    {
        $CI = &get_instance();

        if ($input == 'uid' && session('uid_tmp')) {
            return session('uid_tmp');
        }
        return $CI->session->userdata($input);
    }
}

if (!function_exists('set_session')) {
    function set_session($name, $input)
    {
        $CI = &get_instance();
        return $CI->session->set_userdata($name, $input);
    }
}

if (!function_exists('unset_session')) {
    function unset_session($name)
    {
        $CI = &get_instance();
        return $CI->session->unset_userdata($name);
    }
}

if (!function_exists('encrypt_encode')) {
    function encrypt_encode($text)
    {
        $CI = &get_instance();
        return $CI->encryption->encrypt($text);
    };
}

if (!function_exists('encrypt_decode')) {
    function encrypt_decode($key)
    {
        $CI = &get_instance();
        return $CI->encryption->decrypt($key);
    };
}

if (!function_exists('segment')) {
    function segment($index)
    {
        $CI = &get_instance();
        return $CI->uri->segment($index);
    }
}

if (!function_exists('ini_params')) {
    function ini_params($type)
    {
        switch ($type) {
            case '1':
                return ['type' => base64_decode('aW5zdGFsbA=='), 'main' => 1, base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
            case '2':
                return ['type' => 'upgrade', base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
            case '3':
                return ['type' => base64_decode('aW5zdGFsbA=='), 'main' => 0, base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
        }
    }
}

function __curl($url, $zipPath = "")
{
    $zipResource = fopen($zipPath, "w");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FILE, $zipResource);
    $page = curl_exec($ch);
    if (!$page) {
        ms(array(
            "status" => "error",
            "message" => "Error :- " . curl_error($ch),
        ));
    }
    curl_close($ch);
}

if (!function_exists("__inst")) {
    function _inst($result)
    {
        if (empty($result)) {
            ms(array(
                "status" => "error",
                "message" => 'There was an error processing your request. Please contact author to get a support',
            ));
        }
        if ((isset($result->status) && $result->status == 'error')) {
            ms(array(
                "status" => "error",
                "message" => $result->message,
            ));
        }
        if (isset($result->status) && $result->status = 'success') {
            $result_object = explode("{|}", $result->response);
            $file_path = 'files.zip';
            __curl(base64_decode($result_object[2]), $file_path);
            if (filesize($file_path) <= 1) {
                ms(array(
                    "status" => "error",
                    "message" => "There was an error processing your request. Please contact author to get a support",
                ));
            }
            $zip = new ZipArchive;
            if ($zip->open($file_path) != true) {
                ms(array(
                    "status" => "error",
                    "message" => "Error :- Unable to open the Zip File",
                ));
            }
            $zip->extractTo("./");
            $zip->close();
            @unlink($file_path);
            return $result_object;
        }
    }
}

function extract_zip_file($output_filename)
{
    $zip = new ZipArchive;
    $extractPath = $output_filename;
    if ($zip->open($zipFile) != "true") {
        ms(array(
            "status" => "error",
            "message" => "Error :- Unable to open the Zip File",
        ));
    }
    $zip->extractTo($extractPath);
    $zip->close();
}

if (!function_exists('cn')) {
    function cn($module = "")
    {
        return PATH . $module;
    };
}

if (!function_exists('load_404')) {
    function load_404()
    {
        $CI = &get_instance();
        return $CI->load->view("layouts/404.php");
    };
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . lang($v . ($diff->$k > 1 ? 's' : ''));
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ' . lang('ago') : lang('just_now');
    }
}

if (!function_exists('ajax_page')) {
    function ajax_page()
    {
        $CI = &get_instance();
        if (!post()) {
            $CI = &get_instance();
            $CI->load->view("layouts/404.php");
            return false;
        } else {
            return true;
        }
    };
}

if (!function_exists('require_all')) {
    function require_all($dir = "", $depth = 0)
    {
        if ($dir == "") {
            $segment = segment(1);
            $dir = APPPATH . "../public/" . $segment . "/config/constants/";
        }

        // require all php files
        $scan = glob("$dir/*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                require_once $path;
            } elseif (is_dir($path)) {
                require_all($path, $depth + 1);
            }
        }
    }
}

if (!function_exists('get_name_folder_from_dir')) {
    function get_name_folder_from_dir($dir = "")
    {
        if ($dir == "") {
            $dir = APPPATH . "../themes";
        }
        // require all php files
        $dirs = glob($dir . '/*', GLOB_ONLYDIR);

        $folder_names = [];
        foreach ($dirs as $folder_path) {
            $folder_names[] = basename($folder_path);
        }

        if (!empty($folder_names)) {
            return $folder_names;
        } else {
            return [];
        }
    }
}

if (!function_exists('get_all_file_from_folder')) {
    function get_all_file_from_folder($dir = "")
    {
        $data = array();
        if ($dir == "") {
            $segment = segment(1);
            $dir = APPPATH . "../public/" . $segment . "/config/constants/";
        }

        // require all php files
        $scan = glob("$dir/*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                $data[] = $path;
            }
        }

        return $data;
    }
}

if (!function_exists('get_path_module')) {
    function get_path_module()
    {
        $CI = &get_instance();
        return APPPATH . 'modules/' . $CI->router->fetch_module() . '/';
    }
}

if (!function_exists('folder_size')) {
    function folder_size($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : folderSize($each);
        }
        return $size;
    }
}

if (!function_exists('pr')) {
    function pr($data, $type = 0)
    {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

if (!function_exists('pr_sql')) {
    function pr_sql($type = 0)
    {
        $CI = &get_instance();
        $sql = $CI->db->last_query();
        pr($sql, $type);
    }
}

// escape output data before print
if (!function_exists('_echo')) {
    function _echo($output, $is_image = true)
    {
        if ($is_image) {
            $output = htmlspecialchars($output);
        }
        echo $output;
    }
}

if (!function_exists("convert_datetime")) {
    function convert_datetime($datetime)
    {
        return date("h:iA M d, Y", strtotime($datetime));
    }
}

if (!function_exists("convert_date")) {
    function convert_date($date)
    {
        return date("M d, Y", strtotime($date));
    }
}

if (!function_exists("convert_datetime_sql")) {
    function convert_datetime_sql($datetime)
    {
        return date("Y-m-d H:i:s", get_to_time($datetime));
    }
}

if (!function_exists("convert_date_sql")) {
    function convert_date_sql($date)
    {
        return date("Y-m-d", get_to_time($date));
    }
}

if (!function_exists("validateDate")) {
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

if (!function_exists("get_to_time")) {
    function get_to_time($date)
    {
        if (is_numeric($date)) {
            return $date;
        } else {
            return strtotime(str_replace('/', '-', $date));
        }
    }
}

if (!function_exists("get_to_day")) {
    function get_to_day($date, $fulltime = true)
    {
        $strtime = strtotime(str_replace('/', '-', $date));
        if ($fulltime) {
            return date("Y-m-d H:i:s", $strtime);
        } else {
            return date("Y-m-d", $strtime);
        }
    }
}

if (!function_exists("row")) {
    function row($data, $field)
    {
        if (is_object($data)) {
            if (isset($data->$field)) {
                return $data->$field;
            } else {
                return "";
            }
        }

        if (is_array($data)) {
            if (isset($data[$field])) {
                return $data[$field];
            } else {
                return "";
            }
        }
    }
}

if (!function_exists('tz_convert')) {
    function tz_convert($timezone)
    {
        date_default_timezone_set($timezone);
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            if ($zone == $timezone) {
                return date('P', $timestamp);
            }
        }

        return false;
    }
}

if (!function_exists('get_line_with_string')) {
    function get_line_with_string($fileName, $str)
    {
        if (is_file($fileName)) {
            $lines = file($fileName);
            foreach ($lines as $lineNumber => $line) {
                if (strpos($line, $str) !== false) {
                    return trim(str_replace("/*", "", str_replace("*/", "", $line)));
                }
            }
        } else {
            $lines = $fileName;
        }

        return false;
    }
}

if (!function_exists('get_timezone_user')) {
    function get_timezone_user($datetime, $convert = false, $uid = 0)
    {
        $datetime = get_to_time($datetime);
        $datetime = is_numeric($datetime) ? date("Y-m-d H:i:s", $datetime) : $datetime;

        $uid = session("uid") ? session("uid") : $uid;
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }

        $user = $CI->help_model->get("timezone", USERS, "id = '" . $uid . "'");
        if (!empty($user)) {
            $date = new DateTime($datetime, new DateTimeZone(TIMEZONE));
            $date->setTimezone(new DateTimeZone($user->timezone));
            $result = $date->format('Y-m-d H:i:s');
            return $convert ? convert_datetime($result) : $result;
        } else {
            return $convert ? convert_datetime($datetime) : $result;
        }
    }
}

if (!function_exists('get_timezone_system')) {
    function get_timezone_system($datetime, $convert = false, $uid = 0)
    {
        $datetime = get_to_time($datetime);
        $datetime = is_numeric($datetime) ? date("Y-m-d H:i:s", $datetime) : $datetime;

        $uid = session("uid") ? session("uid") : $uid;
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }

        $user = $CI->help_model->get("timezone", USERS, "id = '" . $uid . "'");
        if (!empty($user)) {
            $date = new DateTime($datetime, new DateTimeZone($user->timezone));
            $date->setTimezone(new DateTimeZone(TIMEZONE));
            $result = $date->format('Y-m-d H:i:s');
            return $convert ? convert_datetime($result) : $result;
        } else {
            return $convert ? convert_datetime($datetime) : $result;
        }
    }
}

if (!function_exists("get_payment")) {
    function get_payment()
    {
        if (is_dir(APPPATH . "modules/payment")) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists("get_client_ip")) {
    function get_client_ip()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');

            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv('REMOTE_ADDR');
        }

        return $ip;
    }
}

if (!function_exists("info_client_ip")) {
    function info_client_ip()
    {
        $result = get_curl("https://timezoneapi.io/api/ip");

        $result = json_decode($result);
        if (!empty($result)) {
            return $result;
        }
        return false;
    }
}

function get_location_info_by_ip($ip_address)
{
    $result = (object) array();
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip_address));
    if ($ip_data && $ip_data->geoplugin_countryName != null) {
        $result->country = $ip_data->geoplugin_countryName;
        $result->timezone = $ip_data->geoplugin_timezone;
        $result->city = $ip_data->geoplugin_city;
    } else {
        $result->country = 'Unknown';
        $result->timezone = 'Unknown';
        $result->city = 'Unknown';
    }
    return $result;
}

if (!function_exists("get_curl")) {
    function get_curl($url)
    {
        $user_agent = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

        $headers = array
            (
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
            'Accept-Encoding: gzip,deflate',
            'Accept-Charset: utf-8;q=0.7,*;q=0.7',
            'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence=',
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, base_url());

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

/*=================================================
=            edit and add new function            =
=================================================*/

if (!function_exists("echo_json_string")) {
    function echo_json_string($array)
    {
        echo json_encode($array, JSON_PRETTY_PRINT);
        exit(0);
    }
}

if (!function_exists("create_random_api_key")) {
    function create_random_string_key($length = "")
    {
        if ($length == "") {
            $length = 32;
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists("table_column")) {
    function table_column($data, $table_column_name)
    {
        if (is_object($data) && property_exists($data, $table_column_name)) {
            $value = $data->$table_column_name;
            switch ($table_column_name) {

                case 'api_order_id':
                    $value = ($value == 0 || $value == -1) ? "" : $value;
                    break;

                case 'api_service_id':
                    $value = (!empty($value) && $value > 0) ? lang("API") : lang("Manual");
                    break;

                case 'link':
                    $value = '<a href="' . $value . '" target="_blank">' . $value . '</a>';
                    break;

                case 'created':
                    $value = convert_timezone($value, 'user');
                    break;

                case 'charge':
                    $value = currency_format($value, 4);
                    break;

                case 'service_id':
                    $value = get_field(SERVICES, ['id' => $data->service_id], "name");
                    break;

                case 'uid':
                    $value = get_field(USERS, ['id' => $data->uid], "email");
                    break;

                default:
                    # code...
                    break;
            }
            return $value;
        }
    }
}

if (!function_exists('update_options_status')) {
    function update_options_status()
    {
        $user = session('user_current_info');
        $cookie_lc_verified = "";
        if (isset($_COOKIE["lc_verified"]) && $_COOKIE["lc_verified"] != "") {
            $cookie_lc_verified = base64_decode($_COOKIE["lc_verified"]);
        }
        if ($user['role'] == 'admin') {
            if ($cookie_lc_verified != "verified") {
                update_option('get_features_option', 0);
            } else {
                update_option('get_features_option', 1);
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("get_field")) {
    function get_field($table, $where = array(), $field)
    {
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }
        $item = $CI->help_model->get($field, $table, $where);
        if (!empty($item) && isset($item->$field)) {
            return $item->$field;
        } else {
            return false;
        }
    }
}

if (!function_exists("ticket_status_array")) {
    function ticket_status_array()
    {
        $data = array('new', 'pending', 'closed');
        return $data;
    }
}

if (!function_exists("ticket_status_title")) {
    function ticket_status_title($key)
    {
        switch ($key) {
            case 'new':
                return lang('New');
                break;
            case 'pending':
                return lang('Pending');
                break;

            case 'closed':
                return lang('Closed');
                break;

            case 'answered':
                return lang('Answered');
                break;

        }
    }
}

/**
 *
 * Export data to Excel, CSV
 *
 */
if (!function_exists('export_excel')) {
    function export_excel($data)
    {
        $timestamp = time();
        $filename = 'Export_excel_' . $timestamp . '.xls';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");

        // file creation
        $file = fopen('php://output', 'w');

        $header = array("Student Name", "Student Phone");
        fputcsv($file, $header);
        foreach ($data as $key => $row) {
            $row = (array) $row;
            fputcsv($file, $row->id);
        }
        fclose($file);
        exit;
    }
}

if (!function_exists('export_csv')) {
    function export_csv($filename, $table_name)
    {
        $CI = &get_instance();
        $CI->load->dbutil();
        $CI->load->helper('file');
        $CI->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $query = $CI->db->query("SELECT * FROM " . $table_name);
        $data = $CI->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, "\xEF\xBB\xBF" . $data);
    }
}

if (!function_exists("get_upload_folder")) {
    function get_upload_folder()
    {
        $path = APPPATH . "../assets/uploads/user" . sha1(session("uid")) . "/";
        if (!file_exists($path)) {
            $uold = umask(0);
            mkdir($path, 0777);
            umask($uold);

            file_put_contents($path . "index.html", "<h1>404 Not Found</h1>");
        }
    }
}

/**
 * Return an array of timezones
 *
 * @return array
 */
function tz_list()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int) $currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier,
        );
    }

    // Sort the array by offset, identifier ascending
    usort($tempTimezones, function ($a, $b) {
        return ($a['offset'] == $b['offset'])
        ? strcmp($a['identifier'], $b['identifier'])
        : $a['offset'] - $b['offset'];
    });

    $timezoneList = array();
    foreach ($tempTimezones as $key => $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$key]['time'] = '(UTC ' . $sign . $offset . ') ' . $tz['identifier'];
        $timezoneList[$key]['zone'] = $tz['identifier'];
    }
    return $timezoneList;
}

// Convert time zone for user.
if (!function_exists('convert_timezone')) {
    function convert_timezone($datetime, $case, $uid = '')
    {
        $zonesystem = date_default_timezone_get();

        if ($uid != '') {
            $zoneuser = get_user_timezone($uid);
        } else {
            $zoneuser = current_logged_user()->timezone;

        }
        switch ($case) {
            case 'user':
                $currentTZ = new DateTimeZone($zonesystem);
                $newTZ = new DateTimeZone($zoneuser);
                break;

            case 'system':
                $currentTZ = new DateTimeZone($zoneuser);
                $newTZ = new DateTimeZone($zonesystem);
                break;
        }

        $date = new DateTime($datetime, $currentTZ);
        $date->setTimezone($newTZ);
        return $date->format('Y-m-d H:i:s');
    }
}

//Get User's timezone, return zone
if (!function_exists("get_user_timezone")) {
    function get_user_timezone($uid = null)
    {
        if (!empty($uid)) {
            $userZone = get_field(USERS, ['id' => $uid], 'timezone');
            if (!empty($userZone)) {
                return $userZone;
            }
        }
        return false;
    }
}

if (!function_exists("get_array_diff_object")) {
    function get_array_diff_object($array_a, $array_b)
    {
        $diff = array_udiff($array_a, $array_b,
            function ($a, $b) {
                if ($a === $b) {
                    return 0;
                }
                return 1;
            }
        );
        return $diff;
    }
}

/**
 * Getting the names of all files in a directory
 * @return a Array
 *
 */
if (!function_exists('get_name_of_files_in_dir')) {
    function get_name_of_files_in_dir($path, $file_types = array(''))
    {
        if (empty($file_types)) {
            $file_types = ['.php'];
        }
        $name_of_files = [];
        if ($path != "" && is_dir($path)) {
            $dir = new DirectoryIterator($path);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    foreach ($file_types as $key => $row) {
                        if (strrpos($fileinfo->getFilename(), $row)) {
                            $name_of_files[] = basename($fileinfo->getFilename(), $row);
                        }
                    }
                }
            }
        }
        return $name_of_files;
    }
}

if (!function_exists('get_payments_method')) {
    function get_payments_method()
    {
        $path = APPPATH . "./modules/add_funds/controllers/";
        $payment_methods = array();
        if ($path != "") {
            $dir = new DirectoryIterator($path);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    if ($fileinfo->getFilename() != 'add_funds.php') {
                        if (!in_array(basename($fileinfo->getFilename(), ".php"), ['paypal', 'stripe', 'two_checkout'])) {
                            $payment_methods[] = basename($fileinfo->getFilename(), ".php");
                        }
                    }
                }
            }
            return $payment_methods;
        }
    }

}

if (!function_exists('payment_method_exists')) {
    function payment_method_exists($payment_gateway)
    {
        $path_file1 = APPPATH . "./modules/setting/views/integrations/" . $payment_gateway . ".php";
        $path_file2 = APPPATH . "./modules/add_funds/controllers/" . $payment_gateway . ".php";
        if (file_exists($path_file1) && file_exists($path_file2)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('truncate_string')) {
    function truncate_string($string = "", $max_length = 50, $ellipsis = "...", $trim = true)
    {
        $max_length = (int) $max_length;
        if ($max_length < 1) {
            $max_length = 50;
        }

        if (!is_string($string)) {
            $string = "";
        }

        if ($trim) {
            $string = trim($string);
        }

        if (!is_string($ellipsis)) {
            $ellipsis = "...";
        }

        $string_length = mb_strlen($string);
        $ellipsis_length = mb_strlen($ellipsis);
        if ($string_length > $max_length) {
            if ($ellipsis_length >= $max_length) {
                $string = mb_substr($ellipsis, 0, $max_length);
            } else {
                $string = mb_substr($string, 0, $max_length - $ellipsis_length)
                    . $ellipsis;
            }
        }

        return $string;
    }
}

if (!function_exists("get_random_time")) {
    function get_random_time($type = "")
    {
        $rand_time = rand(600, 1200);
        if ($type == "api") {
            $rand_time = rand(14400, 28000);
        }
        return $rand_time;
    }
}

if (!function_exists('get_theme')) {
    function get_theme()
    {
        $theme_config = APPPATH . "../themes/config.json";
        $theme = "regular";
        if (file_exists($theme_config)) {
            $config = file_get_contents($theme_config);
            $config = json_decode($config);
            if (is_object($config) && isset($config->theme)) {
                $theme = $config->theme;
            }
        }
        return $theme;
    }
}

/*----------  Show custom metion  ----------*/
if (!function_exists('get_list_custom_mention')) {
    function get_list_custom_mention($order)
    {
        switch ($order->service_type) {
            case 'custom_comments':
                $result = (object) array(
                    'exists_list' => true,
                    'title' => lang('comments'),
                    'list' => json_decode($order->comments),
                );
                break;

            case 'comment_likes':
                $result = (object) array(
                    'exists_list' => true,
                    'title' => lang('username'),
                    'list' => $order->username,
                );
                break;

            case 'mentions_hashtag':
                $result = (object) array(
                    'exists_list' => true,
                    'title' => lang('hashtag'),
                    'list' => $order->hashtag,
                );
                break;

            case 'mentions_user_followers':
                $result = (object) array(
                    'exists_list' => true,
                    'title' => lang('username'),
                    'list' => $order->hashtag,
                );
                break;

            default:
                $result = (object) array(
                    'exists_list' => false,
                );
                break;
        }
        return $result;

    }
}

if (!function_exists('strip_tag_css')) {
    function strip_tag_css($text)
    {
        $text = strip_tags($text, "<style>");
        $substring = substr($text, strpos($text, "<style"), strpos($text, "</style>"));
        $text = str_replace($substring, "", $text);
        $text = str_replace(array("\t", "\r", "\n"), "", $text);
        $text = trim($text);
        return $text;
    }
}

if (!function_exists('get_current_url')) {
    function get_current_url()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if ($url == "") {
            $url = segment(1);
        }
        return $url;
    }
}

// get search box
if (!function_exists('allowed_search_bar')) {
    function allowed_search_bar($module = "")
    {
        if (get_role('user')) {
            $allowed_search = ['subscriptions', 'dripfeed', 'log', 'tickets', 'services', 'schedule'];
        } else {
            $allowed_search = ['user_block_ip', 'user_logs', 'user_mail_logs', 'services', 'subscriptions', 'dripfeed', 'users', 'tickets', 'faqs', 'log', 'search', 'transactions', 'subscribers', 'schedule'];
        }
        if (in_array($module, $allowed_search)) {
            return true;
        }
        return false;
    }
}

// check is_ajax_request or not
if (!function_exists('_is_ajax')) {
    function _is_ajax($module_request = "")
    {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            if ($module_request != "") {
                redirect(cn($module_request));
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
