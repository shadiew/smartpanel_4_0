<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dripfeed extends My_UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "dripfeed";
        $this->params            = [];

        $this->columns     =  array(
            "id"                => ['name' => lang("order_id"),    'class' => ''],
            "order_details"     => ['name' => lang("order_basic_details"), 'class' => 'text-center'],
            "created"           => ['name' => lang("Created"), 'class' => 'text-center'],
            "updated"           => ['name' => lang("Updated"), 'class' => 'text-center'],
            "status"            => ['name' => lang("Status"),  'class' => 'text-center'],
        );
    }

    public function index()
    {
        
        $page        = (int)get("p");
        $page        = ($page > 0) ? ($page - 1) : 0;
        if (in_array($this->controller_name, ['order', 'dripfeed', 'subscriptions'])) {
            $filter_status = (isset($_GET['status'])) ? get('status') : 'all';
        }else{
            $filter_status = (isset($_GET['status'])) ? (int)get('status') : '3';
        }

        $order_status_array = app_config('config')['status']['dripfeed'];
        $order_status_array = array_diff($order_status_array, ['error', 'fail', 'all']);
        if (!in_array($filter_status, $order_status_array)) {
            $filter_status = "all";
        }

        $this->params = [
            'pagination' => [
                'limit'  => $this->limit_per_page,
                'start'  => $page * $this->limit_per_page,
            ],
            'filter' => ['status' => $filter_status],
            'search' => ['query'  => get('query')],
        ];
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $data = array(
            "controller_name"     => $this->controller_name,
            "params"              => $this->params,
            "columns"             => $this->columns,
            "items"               => $items,
            "order_status_array"  => $order_status_array,
            "from"                => $page * $this->limit_per_page,
            "pagination"          => create_pagination([
                'base_url'         => cn($this->controller_name),
                'per_page'         => $this->limit_per_page,
                'query_string'     => $_GET, //$_GET 
                'total_rows'       => $this->main_model->count_items($this->params, ['task' => 'count-items-for-pagination']),
            ]),
        );
        $this->template->build('logs', $data);    
    }
}
