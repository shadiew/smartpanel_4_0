<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_AdminController extends MX_Controller
{

    protected $controller_title  = '';
    protected $controller_name   = '';

    protected $path_views        = '';

    protected $params = [];
    protected $columns = [];
    protected $limit_per_page = 50;

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        if (!is_admin_logged_in()) {
            redirect(cn());
        }
        if (is_admin_logged_in() && segment(2) == "users") {
            $CI->db->query("DELETE FROM general_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 60 MINUTE))");
        }

        if (is_admin_logged_in() && get_option('admin_auto_logout_when_change_ip', 0)) {
            if (current_logged_user()->history_ip !== get_client_ip()) {
                unset_session("uid");
                unset_session("user_current_info");
                redirect(cn());
            }
        }
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
        $this->params = [
            'pagination' => [
                'limit'  => $this->limit_per_page,
                'start'  => $page * $this->limit_per_page,
            ],
            'filter' => ['status' => $filter_status],
            'search' => ['query'  => get('query'), 'field' => get('field')],
        ];
        
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $items_status_count = $this->main_model->count_items($this->params, ['task' => 'count-items-group-by-status']);
        $data = array(
            "controller_name"     => $this->controller_name,
            "params"              => $this->params,
            "columns"             => $this->columns,
            "items"               => $items,
            "items_status_count"  => $items_status_count,
            "from"                => $page * $this->limit_per_page,
            "pagination"          => create_pagination([
                'base_url'         => admin_url($this->controller_name),
                'per_page'         => $this->limit_per_page,
                'query_string'     => $_GET, //$_GET 
                'total_rows'       => $this->main_model->count_items($this->params, ['task' => 'count-items-for-pagination']),
            ]),
        );
        $this->template->build($this->path_views . '/index', $data);
    }

    // Edit form
    public function update($id = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = [
                'id'  => $id, 
                'ids' => $id
            ];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/update', $data);
    }

    // Change status
    public function change_status($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params = [
            'id'        => $id,
            'status'    => (int)post('status'),
        ];
        $response = $this->main_model->save_item($params, ['task' => 'change-status']);
        ms($response);
    }

    // Bulk action
    public function bulk_action($type = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params = [
            'ids'       => post('ids'),
            'type'      => $type,
        ];
        $response = $this->main_model->save_item($params, ['task' => 'bulk-action']);
        ms($response);
    }

    // Delete Item
    public function delete($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params['id'] = $id;
        $response = $this->main_model->delete_item($params, ['task' => 'delete-item']);
        ms($response);
    }

    // export data
    public function export($type = "")
    {
        $items = $this->main_model->list_items(null, ['task' => 'export-list-items']);
        if (empty($items)) {
            redirect(admin_url($this->controller_name));
        }
        $columns = array_keys((array)$items[0]);
        $filename = $this->controller_title . '-' . date("d-m-Y", strtotime(NOW));
        switch ($type) {
            case 'excel':
                if (!empty($items)) {
                    $filename .= ".xlsx";
                    $this->load->library('phpspreadsheet_lib');
                    $phpexel = new Phpspreadsheet_lib();
                    $phpexel->export_excel($columns, $items, $filename);
                }
                break;
            case 'csv':
                if (!empty($items)) {
                    $filename .= ".csv";
                    $this->load->library('phpspreadsheet_lib');
                    $phpexel = new Phpspreadsheet_lib();
                    $phpexel->export_csv($columns, $items, $filename);
                }
                break;

            default:
                $filename .= ".csv";
                export_csv($filename, $this->tb_subscribers);
                break;
        }
    }
}
