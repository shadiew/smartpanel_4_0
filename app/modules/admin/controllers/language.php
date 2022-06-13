<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class language extends My_AdminController {

    private $tb_main = LANGUAGE_LIST;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "language";
        $this->params            = [];

        $this->columns     =  array(
            "name" => ['name' => 'Name', 'class' => 'text-center'],
            "code"        => ['name' => 'Code',        'class' => 'text-center'],
            "icon"       => ['name' => 'Icon',       'class' => 'text-center'],
            "default"       => ['name' => 'default',       'class' => 'text-center'],
            "status"      => ['name' => 'status',      'class' => 'text-center'],
            "created"      => ['name' => 'Created',      'class' => 'text-center'],
        );
    }

    // Edit form
    public function update($id = null){
        $item = null;
        $lang_db = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            //Ver3.2
            $old_path = FCPATH. "app/language/tmp/lang_". $item ['code'] .".txt";
            if (file_exists($old_path)) {
                $lang_db = get_json_content( $old_path );
            }
            // From V3.4
            $new_path = FCPATH. "app/language/data/". $item ['code'] ."_lang.php";
            if (!$lang_db && file_exists($new_path)) {
                include($new_path);
                $lang_db  = (object)$lang;
            }
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "default_lang"      => create_default_lang(),
            "lang_db"           => $lang_db,
        );
        $this->template->build($this->path_views . '/update', $data);
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));

        $this->form_validation->set_rules('default', 'default', 'trim|required|in_list[0,1]|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');

        $task = 'add-item';
        $lang_code_unique = "|is_unique[$this->tb_main.code]";
        $id = $this->input->post('id');
        if ($id) {
            $task   = 'edit-item';
            $lang_code_unique = "|edit_unique[$this->tb_main.code.$id]";
        }
        $this->form_validation->set_rules('language_code', 'language code', 'trim|required|xss_clean'. $lang_code_unique, [
            'is_unique' => 'The language code already exists.',
        ]);

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }
}