<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class api extends My_UserController
{
    public $tb_users;
    public $tb_categories;
    public $tb_services;
    public $tb_orders;
    public $api_key;
    public $uid;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'model');
        //Config Module
        $this->tb_users      = USERS;
        $this->tb_categories = CATEGORIES;
        $this->tb_services   = SERVICES;
        $this->tb_orders     = ORDER;
    }

    public function index(){
        redirect(cn('api/docs'));
    }

    public function docs(){
        $api_key = null;
        $api_key = get_field(USERS, ['id' => session('uid')], "api_key");
            
        $status_order = array(
            "key"            => lang("your_api_key"),
            "action"         => "status",
            "order"          => lang("order_id"),
        );	

        $status_orders = array(
            "key"            => lang("your_api_key"),
            "action"         => "status",
            "orders"         => lang("order_ids_separated_by_comma_array_data"),
        );	

        $services = array(
            "key"            => lang("your_api_key"),
            "action"         => "services",
        );

        $balance = array(
            "key"            => lang("your_api_key"),
            "action"         => "balance",
        );

        $data = array(
            "module"        => get_class($this),
            "api_key"       => $api_key,
            "api_url"       => BASE."api/v1",
            "status_order"  => $status_order,
            "status_orders" => $status_orders,
            "services"      => $services,
            "balance"       => $balance,
        );

        if (!session('uid')) {
            $this->template->set_layout('general_page');
            $this->template->build("index", $data);
        }
        
        $this->template->build("index", $data);
    }

    public function v1(){
        $params = [];
        $this->api_key = (isset($_REQUEST["key"])) ? strip_tags(urldecode($_REQUEST["key"])) : '';
        $action        = (isset($_REQUEST["action"])) ? strip_tags(urldecode($_REQUEST["action"])) : '';
        $order_id      = (isset($_REQUEST["order"])) ? strip_tags(urldecode($_REQUEST["order"])) : '';
        $order_ids     = (isset($_REQUEST["orders"])) ? strip_tags(urldecode($_REQUEST["orders"])) : '';
        // Build parameters and call appropriate sub function
        $params = $_REQUEST;
        $uid_exists = get_field($this->tb_users, ["api_key" => $this->api_key, "status" => 1], "id");
        if ($this->api_key == "" || empty($uid_exists)) {
            echo_json_string(array(
                'error' => lang("api_is_disable_for_this_user_or_user_not_found_contact_the_support"),
            ));
        }
        $this->uid = $uid_exists;

        $action_allowed = array('add', 'status', 'services', 'balance');
        if ($action == "" || !in_array($action, $action_allowed)) {
            echo_json_string(array(
                'error' => lang("this_action_is_invalid"),
            ));
        }

        switch ($action) {
            case 'services':
                $services = $this->model->get_services_list($this->uid);
                if (!empty($services)) {
                    echo_json_string($services);
                }else{
                    echo_json_string(array(
                        'status' => "success",
                        'data'   => "Empty Data",
                    ));
                }
                break;

            case 'add':
                $this->add($_REQUEST);
                break;

            case 'status':
                    
                    if (isset($order_id) && $order_id != "") {
                        $this->single_status($order_id);
                    }	
                            
                    if (isset($order_ids) && $order_ids != "") {
                        $this->multi_status($order_ids);
                    }
                    break;
            
            case 'balance':
                    $this->balance();
                    break;	

            default:
                echo_json_string(array(
                    'error' => lang("this_action_is_invalid"),
                ));
                break;
        }
    }

    private function add($params){
        $service_id = (isset($params["service"])) ? strip_tags(urldecode($params["service"])) : '';
        $link       = (isset($params["link"])) ? strip_tags(urldecode($params["link"])) : '';

        if (!$service_id) {
            echo_json_string(array(
                'error' => lang("there_are_missing_required_parameters_please_check_your_api_manual"),
            ));
        }

        $check_service  = $this->model->check_record("*", $this->tb_services, $service_id, false, true);
        if (empty($check_service)) {
            echo_json_string(array(
                "error" => lang("service_id_does_not_exists")
            ));
        }
        $service_type = $check_service->type;
        switch ($service_type) {

            case 'custom_comments':
                $comments     = (isset($params["comments"])) ? strip_tags(urldecode($params["comments"])) : '';
                if ($comments == "") {
                    echo_json_string(array(
                        "error" => lang("comments_field_is_required")
                    ));
                }
                $comments     = str_replace("\r\n", " | ", $comments);
                $comments     = str_replace("\n", " | ", $comments);
                $comments_arr = explode(" | ", $comments);
                $quantity     = count($comments_arr);
                $is_custom_comments = 1;
                break;
            
            default:
                $quantity     = (isset($params["quantity"])) ? strip_tags(urldecode($params["quantity"])) : '';
                $interval     = (isset($params["interval"])) ? strip_tags(urldecode($params["interval"])) : '';
                $runs         = (isset($params["runs"])) ? strip_tags(urldecode($params["runs"])) : '';
                $interval     = $interval;
                $runs         = $runs;
                if ($runs != '' || $interval != '') {

                    if (!$check_service->dripfeed) {
                        echo_json_string(array(
                            'error' => "This services does not support Dripfeed feature!",
                        ));
                    }
                    
                    if ($runs != '' && $interval == '') {
                        echo_json_string(array(
                            'error' => lang("interval_time_is_required"),
                        ));
                    }

                    if ($runs == '' && $interval != '') {
                        echo_json_string(array(
                            'error' => lang("runs_is_required"),
                        ));
                    }
                    $interval     = (int)$interval;
                    $runs         = (int)$runs;
                    if (!in_array($interval, [0, 5, 10, 15, 30, 60, 90])) {
                        ms(array(
                            "status"  => "error",
                            "message" => 'Invalid Interval in minutes'
                        ));
                    }

                    if ($quantity == '') {
                        echo_json_string(array(
                            'error' => lang("quantity_is_required"),
                        ));
                    }
                    $is_drip_feed      = 1;
                    $dripfeed_quantity = $params['quantity']; 
                    $quantity          = $runs * $dripfeed_quantity;
                }else{
                    $quantity          = $quantity;
                }
                break;
        }

        if ($link == "") {
            echo_json_string(array(
                'error' => 'Bad Link',
            ));
        }

        if ($quantity == '') {
            echo_json_string(array(
                'error' => lang("quantity_is_required"),
            ));
        }
        
        $min   = $check_service->min;
        $max   = $check_service->max;
        $price = get_user_price($this->uid, $check_service);
        
        if ($quantity <= 0 || $quantity < $min) {
            echo_json_string(array(
                "error" => lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount").' '.$min
            ));
        }	
                
        if ($quantity > $max) {
            echo_json_string(array(
                "error" => lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount").' '.$max
            ));
        }

        /*----------  Get user's balance and custom_rate info  ----------*/
        $user = $this->model->get("balance", $this->tb_users, ['id' => $this->uid]);
        /*----------  Set custom rate for each user  ----------*/
        if ($service_type == "package" || $service_type == "custom_comments_package") {
            $total_charge = $price;
        }else{
            $total_charge = $price*($quantity/1000);
        }
        
        if ((!empty($user->balance) && $user->balance < $total_charge) || empty($user->balance)) {
            echo_json_string(array(
                "error" => lang("not_enough_funds_on_balance")
            ));
        }

        $data = array(
            "ids" 	            => ids(),
            "uid" 	            => $this->uid,
            "type" 	            => 'api',
            "cate_id" 	        => $check_service->cate_id,
            "service_id" 	    => $check_service->id,
            "link" 	            => $link,
            "quantity" 	        => $quantity,
            "charge" 	        => $total_charge,
            "api_provider_id"  	=> $check_service->api_provider_id,
            "api_service_id"  	=> $check_service->api_service_id,
            "api_order_id"  	=> (!empty($check_service->api_provider_id) && !empty($check_service->api_service_id)) ? -1 : 0,
            "status"			=> 'pending',
            "service_type"	    => $service_type,
            "changed" 	        => NOW,
            "created" 	        => NOW,
        );

        /*----------  Get Formal Charge and profit  ----------*/
        $data['formal_charge'] = ($check_service->original_price * $total_charge) / $check_service->price;
        $data['profit']        = $total_charge - $data['formal_charge'];
        /*----------  insert more params  ----------*/
        switch ($service_type) {
            case 'custom_comments':
                $data["comments"]  = json_encode(str_replace(" | ", "\n", $comments));
                break;

            default:
                // add params for Dripfeed Order type
                if (isset($is_drip_feed) && $is_drip_feed) {
                    $data['is_drip_feed']      = 1;
                    $data['runs']              = $runs;
                    $data['interval']          = $interval;
                    $data['dripfeed_quantity'] = $dripfeed_quantity;
                    $data['status']            = 'inprogress';
                }
                break;
        }

        $this->db->insert($this->tb_orders, $data);
        if ($this->db->affected_rows() > 0) {
            $insert_order_id = $this->db->insert_id();
            $new_balance = $user->balance - $total_charge;
            $this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => $this->uid]);
            if ($this->db->affected_rows() > 0) {
                echo_json_string(array(
                    'status' => "success",
                    "order"  => $insert_order_id,
                ));
            }
        }else{
            echo_json_string(array(
                "error" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
            ));
        }
    }

    private function balance(){
        $get_balance = $this->model->check_record("balance", $this->tb_users, $this->uid, false, true);
        if (!empty($get_balance)) {
            echo_json_string(array(
                "status"   => "success",
                "balance"  => $get_balance->balance,
                "currency" => "USD"
            ));
        }else{
            echo_json_string(array(
                "error"  => lang("the_account_does_not_exists"),
            ));
        }
    }

    private function single_status($order_id){
        if ($order_id == "") {
            echo_json_string(array(
                'error' => lang("order_id_is_required_parameter_please_check_your_api_manual")
            ));
        }

        if (!is_numeric($order_id)) {
            echo_json_string(array(
                'error' => lang("incorrect_order_id"),
            ));
        }

        $exists_order = $this->model->get('id, service_type ,status, charge, start_counter, remains, runs, is_drip_feed, sub_response_orders, sub_expiry, sub_posts', $this->tb_orders, ['id' => $order_id, 'uid' => $this->uid]);

        if (empty($exists_order)) {
            echo_json_string(array(
                'error' => lang("incorrect_order_id"),
            ));
        }else{

            switch ($exists_order->service_type) {
                case 'subscriptions':
                    $orders = [];
                    $related_orders = $this->model->fetch("id, status", $this->tb_orders, ['main_order_id' => $exists_order->id]);
                    if (!empty($related_orders)) {
                        foreach ($related_orders as $key => $order) {
                            $orders[]= $order->id;
                        }
                    }
                    $result = array(
                        'status'      => $this->order_title_status($exists_order->status),
                        'expiry'      => (strtotime($exists_order->sub_expiry) < strtotime(NOW)) ? false : true,
                        'posts'       => $exists_order->sub_posts,
                        'orders'      => $orders,
                    );
                    echo_json_string($result);
                    break;
                
                default:
                    if ($exists_order->is_drip_feed) {
                        $orders = [];
                        $related_orders = $this->model->fetch("id, status", $this->tb_orders, ['main_order_id' => $exists_order->id]);
                        if (!empty($related_orders)) {
                            foreach ($related_orders as $key => $order) {
                                $orders[]= $order->id;
                            }
                        }
                        $result = array(
                            'status'      => $this->order_title_status($exists_order->status),
                            'runs'        => $exists_order->runs,
                            'orders'      => $orders,
                        );
                        
                    }else{
                        $result = array(
                            'order'       => $exists_order->id,
                            'status'      => $this->order_title_status($exists_order->status),
                            'charge'      => $exists_order->charge,
                            'start_count' => $exists_order->start_counter,
                            'remains'     => $exists_order->remains,
                            'currency'    => 'USD',
                        );
                    }
                    echo_json_string($result);
                    break;
            }

        }
    }

    private function multi_status($order_ids){
        
        if ($order_ids == "") {
            echo_json_string(array(
                'error' => lang("order_id_is_required_parameter_please_check_your_api_manual"),
            ));
        }
        if (is_string($order_ids)) {
            $order_ids = explode(',', $order_ids);
        }

        if (is_array($order_ids)) {
            $data = [];
            foreach ($order_ids as $order_id) {
                $exists_order = $this->model->get('id, service_type ,status, charge, start_counter, remains, runs, is_drip_feed, sub_response_orders, sub_expiry, sub_posts', $this->tb_orders, ['id' => $order_id, 'uid' => $this->uid]);
                if (empty($exists_order)) {
                    $data[$order_id] = "Incorrect order ID";
                }else{
                    switch ($exists_order->service_type) {
                        case 'subscriptions':
                            $orders = [];
                            $related_orders = $this->model->fetch("id, status", $this->tb_orders, ['main_order_id' => $exists_order->id]);
                            if (!empty($related_orders)) {
                                foreach ($related_orders as $key => $order) {
                                    $orders[]= $order->id;
                                }
                            }
                            $result = array(
                                'status'      => $this->order_title_status($exists_order->status),
                                'expiry'      => (strtotime($exists_order->sub_expiry) < strtotime(NOW)) ? false : true,
                                'posts'       => $exists_order->sub_posts,
                                'orders'      => $orders,
                            );
                            break;
                        
                        default:
                            if ($exists_order->is_drip_feed) {
                                $orders = [];
                                $related_orders = $this->model->fetch("id, status", $this->tb_orders, ['main_order_id' => $exists_order->id]);
                                if (!empty($related_orders)) {
                                    foreach ($related_orders as $key => $order) {
                                        $orders[]= $order->id;
                                    }
                                }
                                $result = array(
                                    'status'      => $this->order_title_status($exists_order->status),
                                    'runs'        => $exists_order->runs,
                                    'orders'      => $orders,
                                );
                                
                            }else{
                                $result = array(
                                    'order'       => $exists_order->id,
                                    'status'      => $this->order_title_status($exists_order->status),
                                    'charge'      => $exists_order->charge,
                                    'start_count' => $exists_order->start_counter,
                                    'remains'     => $exists_order->remains,
                                    'currency'    => 'USD',
                                );
                            }
                            break;
                    }
                    $data[$order_id] = $result;
                }
            }
            echo_json_string($data);
        }

        echo_json_string(array(
            'error' => lang("incorrect_order_id"),
        ));
    }

    private function order_title_status($status){
        switch ($status) {

            case 'active':
                $result = 'Active';
                break;
                
            case 'completed':
                $result = 'Completed';
                break;

            case 'processing':
                $result = 'Processing';
                break;

            case 'pending':
                $result = 'Pending';
                break;

            case 'inprogress':
                $result = 'In progress';
                break;

            case 'partial':
                $result = 'Partial';
                break;

            case 'canceled':
                $result = 'Canceled';
                break;

            case 'refunded':
                $result = 'Refunded';
                break;

            default:
                $result = 'Pending';
                break;

        }

        return $result;
    }
}

