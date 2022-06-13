<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class plugins extends My_AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        $this->config = get_json_content(APPPATH. './hooks/config.json');
        $this->secret_key = $this->config->secret_key;
        $this->publish_key = $this->config->publish_key;
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "plugins";
        $this->tb_purchase       = PURCHASE;
        $this->params            = [];
    }

    public function index(){
        $item = $this->main_model->get_item(['id' => 1], ['task' => 'get-item-main']);
        if (empty($item)) {
            redirect(admin_url('setting/website_setting'));
        }
        $scripts = "";
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $item['purchase_code'])) {
            redirect(admin_url('setting/website_setting'));
        }
        $result = get_json_content(base64_decode($this->publish_key).'/script_list', ['purchase_code' => urlencode(trim($item['purchase_code']))]);
        if (!empty($result)) {
            if (!empty($result->scripts)) {
                $scripts = $result->scripts;
            }
        }
        if (empty($scripts)) {
            redirect(admin_url('setting/website_setting'));
        }
        $items = $this->main_model->list_items(null, ['task' => 'list-items']);
        $data = array(
            "controller_name"           => $this->controller_name,
            "scripts"                   => $scripts,
            "purchase_code_lists"       => $items
        );
        $this->template->build($this->path_views . '/index', $data);
    }

    public function ajax_install_module($code = '')
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        if ($code) {
            $action = 2;
        } else {
            $code = post("purchase_code");
            $action = 3;
        }
        if ($code == "") {
            _validation('error', "Purchase code is required");
        }
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            _validation('error', "Purchase code invalid");
        }
        $result = _inst(get_json_content(base64_decode($this->secret_key), array_merge(ini_params($action), ['purchase_code' => $code])));
        if (!$result) {
            _validation('error', "There was issue with your request");
        }
        $response = $this->main_model->save_item(['item_data' => $result, 'code' => $code], ['task' => 'install-upgrade-item']);
        ms($response);
    }
}