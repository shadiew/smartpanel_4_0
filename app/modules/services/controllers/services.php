<?php
defined('BASEPATH') or exit('No direct script access allowed');

class services extends My_UserController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "";
        $this->params = [];
        $this->columns = array(
            "id" => ['name' => 'ID', 'class' => 'text-center'],
            "name" => ['name' => lang('Name'), 'class' => 'text-center'],
            "price" => ['name' => lang("rate_per_1000") . "(" . get_option("currency_symbol", "") . ")", 'class' => 'text-center'],
            "min_max" => ['name' => lang("min__max_order"), 'class' => ''],
            "desc" => ['name' => lang("Description"), 'class' => 'text-center'],
        );
    }

    public function index()
    {
        if (!session('uid') && get_option("enable_service_list_no_login") != 1) {
            redirect(cn());
        }
        $this->params = [
            'cate_id' => 0,
        ];
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $items_custom_rate = $this->main_model->list_items($this->params, ['task' => 'list-items-user-price']);

        $this->load->model('client/client_model', 'client_model');
        $items_category = $this->client_model->list_items($this->params, ['task' => 'list-items-category-in-services']);

        $data = array(
            "controller_name" => $this->controller_name,
            "params" => $this->params,
            "columns" => $this->columns,
            "items" => $items,
            "items_custom_rate" => $items_custom_rate,
            "items_category" => $items_category,
        );
        if (session('uid')) {
            $this->template->build("index", $data);
        } else {
            $this->template->set_layout('general_page');
            $this->template->build("index", $data);
        }
    }

    public function sort($cate_id)
    {
        if (!$this->input->is_ajax_request()) {
            redirect(cn($this->controller_name));
        }

        $this->params = [
            'cate_id' => (int) $cate_id,
        ];
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        if ($items) {
            $items_custom_rate = $this->main_model->list_items($this->params, ['task' => 'list-items-user-price']);
            $data = array(
                "controller_name" => $this->controller_name,
                "params" => $this->params,
                "columns" => $this->columns,
                "items" => $items,
                "items_custom_rate" => $items_custom_rate,
            );
            $this->load->view("child/index", $data);
        } else {
            echo show_empty_item();
        }
    }
}
