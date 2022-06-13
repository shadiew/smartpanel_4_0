<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class provider extends My_AdminController {
    protected $provider;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "provider";
        $this->params            = [];

        $this->columns     =  array(
            "name"             => ['name' => 'Name',    'class' => ''],
            "balance"          => ['name' => 'Balance', 'class' => 'text-center'],
            "description"      => ['name' => 'Description', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
        $this->provider = new Smm_api();
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('url', 'api url', 'trim|required|xss_clean');
        $this->form_validation->set_rules('key', 'api key', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $result = $this->provider->balance(['url' => post('url'), 'key' => post('key')]);
        if ($result && isset($result['balance'])) {
            $this->params["balance"] = $result['balance'];
        } else {
            _validation('error', 'There seems to be an issue connecting to API provider. Please check API key and Token again!');
        }
        
        $task = 'add-item';
        if($this->input->post('id')){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function balance($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        //Check item
        $item = $this->main_model->get_item(['id' => $id], ['task' => 'get-item']);
        if (!$item) _validation('error', 'The provider does not exists');
        $result = $this->provider->balance($item);
        if ($result && isset($result['balance'])) {
            $this->params["balance"] = $result['balance'];
            $this->params["id"]      = $id;
        } else {
            _validation('error', 'There seems to be an issue connecting to API provider. Please check API key and Token again!');
        }
        $response = $this->main_model->save_item($this->params, ['task' => 'balance-item']);
        ms($response);
    }

    public function services($id = "")
    {
        //Check item
        $item = $columns = $item_services = $items_category = null;
        $item = $this->main_model->get_item(['id' => $id], ['task' => 'get-item']);
        $items_provider = $this->main_model->list_items(null, ['task' => 'list-items-in-import-services']);
        if ($item) {
            $columns     =  array(
                "id"               => ['name' => '#',    'class' => ''],
                "name"             => ['name' => 'Name',    'class' => ''],
                "category"         => ['name' => 'category', 'class' => 'text-center'],
                "service_type"     => ['name' => 'service_type', 'class' => 'text-center'],
                "rate"             => ['name' => 'Rate per 1k',  'class' => 'text-center'],
            );
            $item_services = $this->provider->services($item);
            $this->load->model('Category_model', 'category_model');
            $items_category = $this->category_model->list_items($this->params, ['task' => 'list-items-in-services']);
        }
        $data = array(
            "controller_name"     => $this->controller_name,
            "params"              => $this->params,
            "columns"             => $columns,
            "item"                => $item,
            "item_services"       => $item_services,
            "items_provider"      => $items_provider,
            "items_category"      => $items_category,
        );

        if ($this->input->is_ajax_request()) {
            $this->load->view($this->path_views . '/child/services', $data);
        } else {
            $this->template->build($this->path_views . '/services', $data);
        };
    }

    public function sync_services($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        if ($this->input->post('api_id')) {
            $item = $this->main_model->get_item(['id' => post('api_id')], ['task' => 'get-item']);
            if (!$item) _validation('error', 'Provider does not exists!');

            $this->params = [
                'api_id'                         => post('api_id'),
                'price_percentage_increase'      => (int)post('price_percentage_increase'),
                'sync_request_type'              => (int)post('sync_request'),
                'sync_request_options'           => post('sync_request_options'),
                'item_provider'                  => $item,
                'items_provider_service'         => $this->provider->services($item),
            ];
            $response = $this->main_model->crud_services($this->params, ['task' => 'sync-services']);
            $data = [
                'item_provider'      => $item,
                'new_services'       => $response['new_services'],
                'disabled_services'  => $response['disabled_services'],
            ];
            $this->load->view($this->path_views . '/sync_services_result', $data);
            
        } else {
            $item = $this->main_model->get_item(['id' => $id], ['task' => 'get-item']);
            $data = array(
                "controller_name"     => $this->controller_name,
                "params"              => $this->params,
                "item"                => $item,
            );
            $this->load->view($this->path_views . '/sync_services', $data);
        }
    }

    public function import_services(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('api_id', 'provider', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cate_id', 'category', 'trim|required|greater_than[0]|xss_clean', [
            'required' => 'Please choose category',
            'greater_than' => 'Please choose category!'
        ]);
        $this->form_validation->set_rules('price_percentage_increase', 'price_percentage_increase', 'trim|required|is_natural|xss_clean', [
            'is_natural' => 'Price Percentage increase in invalid format!'
        ]);
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if (!post('ids')) _validation('error', 'Please choose at least one item!');
        
        $item = $this->main_model->get_item(['id' => post('api_id')], ['task' => 'get-item']);
        if (!$item) _validation('error', 'Provider does not exists!');

        $this->params = [
            'cate_id'                        => (int)post('cate_id'),
            'service_ids'                    => post('ids'),
            'api_id'                         => post('api_id'),
            'price_percentage_increase'      => (int)post('price_percentage_increase'),
            'convert_to_new_currency'        => post('convert_to_new_currency'),
            'items_provider_service'         => $this->provider->services($item),
        ];
        $response = $this->main_model->crud_services($this->params, ['task' => 'import-services-by-cate-id']);
        ms($response);
    }

    public function import_bulk_services($id = "")
    {
        //Check item
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));

        if ($this->input->post('api_id')) {
            $item = $this->main_model->get_item(['id' => post('api_id')], ['task' => 'get-item']);

            if (!$item) _validation('error', 'Provider does not exists!');
            $this->form_validation->set_rules('api_id', 'provider', 'trim|required|xss_clean');
            $this->form_validation->set_rules('price_percentage_increase', 'price percentage increase', 'trim|required|is_natural|xss_clean', [
                'is_natural' => 'Price Percentage increase in invalid format!'
            ]);
            $this->form_validation->set_rules('convert_to_new_currency', 'convert to new rate', 'trim|in_list[0,1]|xss_clean');

            if (!$this->form_validation->run()) _validation('error', validation_errors());

            $this->params = [
                'api_id'                         => post('api_id'),
                'price_percentage_increase'      => (int)post('price_percentage_increase'),
                'limit'                          => post('limit'),
                'convert_to_new_currency'        => post('convert_to_new_currency'),
                'items_provider_service'         => $this->provider->services($item),
            ];
            $response = $this->main_model->crud_services($this->params, ['task' => 'bulk-import-service']);
            ms($response);
        } else {
            $item = $this->main_model->get_item(['id' => $id], ['task' => 'get-item']);
            $data = array(
                "controller_name"     => $this->controller_name,
                "params"              => $this->params,
                "item"                => $item,
            );
            $this->load->view($this->path_views . '/bulk_services', $data);
        }
    }
}
