<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class users extends My_AdminController {

    private $tb_main = USERS;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "users";
        $this->params            = [];
        $this->tb_main           = USERS;
        $this->columns     =  array(
            "users"            => ['name' => 'User Profile',    'class' => ''],
            "funds"            => ['name' => 'Balance', 'class' => 'text-center'],
            "custom_rate"      => ['name' => 'Custom rate', 'class' => 'text-center'],
            "role"             => ['name' => 'Role',    'class' => 'text-center'],
            "created"          => ['name' => 'Created',  'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
    }

    // Edit Users
    public function update($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;

        $this->load->model('payments_model');
        $items_payment = $this->payments_model->list_items('', ['task' => 'admin-active-list-items']);
        
        if ($ids !== null) {
            $this->params = ['ids' => $ids];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "items_payment"     => $items_payment,
        );
        $this->load->view($this->path_views . '/update', $data);
    }

    // More details
    public function info($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;

        
        if ($ids !== null) {
            $this->params = ['ids' => $ids];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            $item_infor = $item['more_information'];
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "item_infor"        => $item_infor,
        );
        $this->load->view($this->path_views . '/info', $data);
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');
        $this->form_validation->set_rules('timezone', 'timezone', 'trim|required|xss_clean');
        $ids = post('ids');
        $email_unique = "|edit_unique[$this->tb_main.email.$ids]";
        if ($ids) {
            if (post('store_type') != 'user_information') {
                $task   = 'edit-item';
            } else {
                $task   = 'edit-item-information';
            }
        } else {
            $task = 'add-item';
            $email_unique = "|is_unique[$this->tb_main.email]";
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
        }
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean'. $email_unique, [
            'is_unique' => 'The email already exists.',
        ]);
        if (!$this->form_validation->run() && in_array($task, ['add-item', 'edit-item'])) _validation('error', validation_errors());
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    // add_funds
    public function add_funds($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));

        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('payment_method', 'payment method', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'amount', 'trim|required|validate_money|greater_than[0]|xss_clean');
            $this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');
            $this->form_validation->set_rules('transaction_id', 'transaction id', 'trim|xss_clean');
            $this->form_validation->set_rules('txt_fee', 'note', 'trim|xss_clean');

            if (!$this->form_validation->run()) _validation('error', validation_errors());

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            //Check secret key
            $is_valid_secret_key = $this->main_model->verify_admin_access(['secret_key' => post('secret_key')], ['task' => 'check-admin-secret-key']);
            if ($is_valid_secret_key) {
                $response = $this->main_model->save_funds( ['item' => $item], ['task' => 'add-funds']);
                ms($response);
            } else {
                _validation('error', 'The secret key is invalid.');
            }
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $this->load->model('payments_model');
            $items_payment = $this->payments_model->list_items(null, ['task' => 'user-list-items-add-funds']);

            $data = array(
                "controller_name"   => $this->controller_name,
                "item"              => $item,
                "items_payment"     => $items_payment,
            );
            $this->load->view($this->path_views . '/add_funds', $data);
        }
    }

    // Edit Funds
    public function edit_funds($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('new_balance', 'new balance', 'trim|required|validate_money|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) _validation('error', validation_errors());

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            $is_valid_secret_key = $this->main_model->verify_admin_access(['secret_key' => post('secret_key')], ['task' => 'check-admin-secret-key']);
            if ($is_valid_secret_key) {
                $response = $this->main_model->save_funds(['item' => $item], ['task' => 'edit-funds']);
                ms($response);
            } else {
                _validation('error', 'The secret key is invalid.');
            }
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $data = array(
                "controller_name"   => $this->controller_name,
                "item"              => $item,
            );
            $this->load->view($this->path_views . '/edit_funds', $data);
        }
    }

    // Set Password
    public function set_password($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
            $this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) _validation('error', validation_errors());

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            $is_valid_secret_key = $this->main_model->verify_admin_access(['secret_key' => post('secret_key')], ['task' => 'check-admin-secret-key']);
            if ($is_valid_secret_key) {
                $response = $this->main_model->save_item(null, ['task' => 'set-password']);
                ms($response);
            } else {
                _validation('error', 'The secret key is invalid.');
            }
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $data = array(
                "controller_name"   => $this->controller_name,
                "item"              => $item,
            );
            $this->load->view($this->path_views . '/set_password', $data);
        }
    }

    // Send Mail
    public function mail($ids = null)
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('subject', 'subject', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('message', 'message', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('email_to', 'Receiving email', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) _validation('error', validation_errors());

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            $subject       = get_option("website_name", "") . " - " . post('subject');
            $email_content = post('message');
            $check_email_issue = $this->main_model->send_email($subject, $email_content, $item['id'], false);
            if ($check_email_issue) _validation('error', $check_email_issue);
            ms(['status' => 'success', 'message' => 'The email has been successfully sent']);
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $data = array(
                "controller_name"   => $this->controller_name,
                "item"              => $item,
            );
            $this->load->view($this->path_views . '/send_mail', $data);
        }
    }

    // ajax_modal_custom_rates
    public function custom_rate($ids = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = $this->main_model->get_item(['ids' => $ids], ['task' => 'get-item-user-custom-rate']);
        if ($item) {
            $items_user_prices = $this->main_model->list_items(['uid' => $item['id']], ['task' => 'user-price-list-items']);
            $this->load->model('Services_model', 'services_model');
            $items_service    = $this->services_model->list_items(['status' => 1], ['task' => 'user-custom-rate-list-items']);
            $data = [
                'controller_name'   => $this->controller_name,
                'item'              => $item,
                'items_user_prices' => $items_user_prices,
                'items_service'     => $items_service,
            ];
            $this->load->view($this->path_views . '/custom_rate', $data);
        }else{
            echo 	'<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="alert  alert-dismissible">
                              <button type="button" class="close" data-dismiss="modal"></button>
                              <h4>Warning!</h4>
                              <p>
                               User is inactive mode, please active this user before adding custom rate!
                              </p>
                              <div class="btn-list">
                                <button class="btn btn-warning btn-sm" type="button" data-dismiss="modal">Okay</button>
                              </div>
                            </div>
                        </div>
                     </div>';
        }
    }

    public function form_custom_rates()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));

        $custom_rates = post('customRates');
        unset($custom_rates['__serviceID__']);
        $this->params = [
            'custom_rates' =>  $custom_rates,
            'user_ids'     =>  post('ids'),
        ];
        $response = $this->main_model->save_custom_rates($this->params, ['task' => 'set-custom-rate']);
        ms($response);
    }

    public function view_user($ids = ""){
        $this->params = ['ids' => $ids];
        $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        if (empty($item)) {
            _validation('error', 'There was an error processing your request. Please try again later....');
        }
        set_session('uid_tmp', $item['id']);
        unset_session("user_current_info");
        if (session('uid_tmp')) {
            ms([
                'status'       => 'success', 
                'message'      => 'Your request is being processed', 
                'redirect_url' => cn('profile')
            ]);
        }
    }
}
