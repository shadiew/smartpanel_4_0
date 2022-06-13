<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class settings extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "settings";
        $this->params            = [];
    }

    public function index($tab = ""){
        $path              = APPPATH.'./modules/admin/views/settings/elements';
        $elements = get_name_of_files_in_dir($path, ['.php']);
        if (!in_array($tab, $elements) || $tab == "") {
            $tab = 'website_setting';
        }
        $data = array(
            "module" => get_class($this),
            "controller_name"   => $this->controller_name,
            "tab"               => $tab,
        );
        $this->template->build( $this->path_views . '/index', $data);

    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $data = $this->input->post();
        $default_home_page = $this->input->post("default_home_page");
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                if (in_array($key, ['embed_javascript', 'embed_head_javascript', 'manual_payment_content'])) {
                    $value = htmlspecialchars(@$_POST[$key], ENT_QUOTES);
                }
                if ($key == 'new_currecry_rate') {
                    $value = (float)$value;
                    if ($value <= 0) {
                        $value = 1;
                    }
                }
                update_option($key, $value);
                // update_configs(['slug' => $key, 'value' => $value]);
            }
        }
        if ($default_home_page != "") {
            $theme_file = fopen(APPPATH . "../themes/config.json", "w");
            $txt = '{ "theme" : "' . $default_home_page . '" }';
            fwrite($theme_file, $txt);
            fclose($theme_file);
        }
        ms(["status"  => "success", "message" => 'Update successfully']);
    }
}