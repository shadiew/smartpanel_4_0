<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class services extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "services";
        $this->params            = [];

        $this->columns     =  array(
            "id"             => ['name' => 'ID',    'class' => 'text-center'],
            "name"           => ['name' => 'Name',    'class' => ''],
            "provider"       => ['name' => 'provider',    'class' => 'text-center'],
            "type"           => ['name' => 'type',    'class' => 'text-center'],
            "rate"           => ['name' => 'Rate per 1k', 'class' => 'text-center'],
            "min_max"        => ['name' => 'Min/Max', 'class' => 'text-center'],
            "description"    => ['name' => 'description', 'class' => 'text-center'],
            "status"         => ['name' => 'Status',  'class' => 'text-center'],
        );
        $this->provider = new Smm_api();
        $this->load->model('Category_model', 'category_model');
        $this->load->model('Provider_model', 'provider_model');
    }

    public function index()
    {
        $page        = (int)get("p");
        $page        = ($page > 0) ? ($page - 1) : 0;
        $limit_per_page = 50;
        $this->params = [
            'sort_by' => ['cate_id' => (isset($_GET['sort_by'])) ? (int)get('sort_by') : ''],
            'search'  => ['query'   => get('query'), 'field' => get('field')],
        ];
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $items_category = $this->category_model->list_items($this->params, ['task' => 'list-items-in-services']);
        $data = array(
            "controller_name"     => $this->controller_name,
            "params"              => $this->params,
            "columns"             => $this->columns,
            "items"               => $items,
            "items_category"      => $items_category,
        );
        $this->template->build($this->path_views . '/index', $data);
    }

    // Edit form
    public function update($id = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }

        $items_category = $this->category_model->list_items($this->params, ['task' => 'list-items-in-services']);
        $items_provider = $this->provider_model->list_items($this->params, ['task' => 'list-items-in-import-services']);
        
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "items_category"    => $items_category,
            "items_provider"    => $items_provider,
        );
        $this->load->view($this->path_views . '/update', $data);
    }

    public function store(){

        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $min = post('min');
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('min', 'min order', 'trim|required|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('max', 'max order', "trim|required|greater_than_equal_to[$min]xss_clean");
        $this->form_validation->set_rules('add_type', 'Mode', 'trim|in_list[manual,api]|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');

        if (post('add_type') == 'api') {
            $this->form_validation->set_rules('api_provider_id', 'Provider', 'trim|required|xss_clean');
            $this->form_validation->set_rules('api_service_id', 'API Service ID', 'trim|required|xss_clean');
            $this->form_validation->set_rules('api_service_type', 'API Service Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('api_service_dripfeed', 'API Service Drip-Feed', 'trim|required|xss_clean');
            $this->form_validation->set_rules('original_price', 'Original price', 'trim|required|xss_clean');
        } else {
            $config_service_type = implode(',', array_keys(app_config('template')['service_type']));
            $this->form_validation->set_rules('dripfeed', 'dripfeed', 'trim|required|in_list[0,1]|xss_clean');
            $this->form_validation->set_rules('service_type', 'Service Type', "trim|in_list[$config_service_type]|xss_clean", [
                'in_list' => 'Invalid Service Type!'
            ]);
        }
        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $task = 'add-item';
        if($this->input->post('id')){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    // Delete Custom rate Item
    public function delete_custom_rate($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params['id'] = $id;
        $response = $this->main_model->delete_item($params, ['task' => 'delete-custom-rate-item']);
        ms($response);
    }

    public function provider_services()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = $this->provider_model->get_item(['id' => post('provider_id')], ['task' => 'get-item']);
        if (!empty($item)) {
            $items_provider_service = $this->provider->services($item);
            $xhtml_option = '<option value="0">Choose Service</option>';
            if ($items_provider_service) {
                if(!in_array($item['type'], ['realfans'] )){
                    usort($items_provider_service, function($a, $b) {return $a['service'] - $b['service'];});
                }
                foreach ($items_provider_service as $key => $item) {
                    $data_attr = null;
                    foreach ($item as $attr => $value) {
                        if (in_array($attr, ['min', 'max', 'dripfeed', 'refill'])) {
                            $value = (int)$value;
                        }
                        if ($attr == 'type') {
                            $value = service_type_format($value);
                        }
                        $data_attr .= ' data-'. $attr .'="' . $value . '"';
                    }
                    $class_selected = (post('provider_service_id') == $item['service']) ? 'selected' : '';
                    $xhtml_option .= sprintf(
                        '<option %s value="%s" %s>ID%s - (%s) - %s</option>', 
                        $class_selected, $item['service'], $data_attr, $item['service'], (double)$item['rate'], truncate_string($item['name'], 60)
                    );
                }
            }
            echo $xhtml_option;
        }
    }
}
