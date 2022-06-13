<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cron_model extends MY_Model {
    protected $tb_main;

    public function __construct(){
        parent::__construct();
        $this->get_class();
        $this->tb_main    = ORDER;
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items-new-order') {
            $where = "(`status` = 'pending' or `status` = 'inprogress')";
            $this->db->select("*");
            $this->db->from($this->tb_main);
            $this->db->where($where);
            $this->db->where("api_provider_id !=", 0);
            $this->db->where("api_order_id =", -1);
            $this->db->order_by("id", 'ASC');
            $this->db->limit(5, 0);
            $query = $this->db->get();
            $result = $query->result();
        }

        if ($option['task'] == 'list-items-status') {
            $this->db->select("*");
            $this->db->from($this->tb_main);
            $this->db->where_in('status', ['active', 'processing', 'inprogress', 'pending']);
            $this->db->where('api_order_id >', 0);
            $this->db->where('changed <', NOW);
            $this->db->where('service_type !=', 'subscriptions');
            $this->db->where('is_drip_feed', 0);
            $this->db->order_by("id", 'ASC');
            $this->db->limit($params['limit'], $params['start']);
            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'list-items-dripfeed-status') {
            $this->db->select("*");
            $this->db->from($this->tb_main);
            $this->db->where_in('status', ['active', 'processing', 'inprogress', 'pending']);
            $this->db->where('api_order_id >', 0);
            $this->db->where('changed <', NOW);
            $this->db->where('service_type', 'default');
            $this->db->where('is_drip_feed', 1);
            $this->db->order_by("id", 'ASC');
            $this->db->limit($params['limit'], $params['start']);
            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'list-items-subscriptions-status') {
            $this->db->select("*");
            $this->db->from($this->tb_main);
            $this->db->where_in('sub_status', ['Active', 'Paused', '']);
            $this->db->where('api_order_id >', 0);
            $this->db->where('changed <', NOW);
            $this->db->where('service_type', 'subscriptions');
            $this->db->order_by("id", 'ASC');
            $this->db->limit($params['limit'], $params['start']);
            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'list-items-multiple-status') {
            $this->db->select("*");
            $this->db->from($this->tb_main);
            $this->db->where_in('status', ['active', 'processing', 'inprogress', 'pending']);
            $this->db->where('api_order_id >', 0);
            $this->db->where('changed <', NOW);
            $this->db->where('service_type !=', 'subscriptions');
            $this->db->where('is_drip_feed !=', 1);
            $this->db->order_by("id", 'ASC');
            $this->db->limit($params['limit'], $params['start']);
            $query = $this->db->get();
            $result = $query->result_array();
        }

        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item-provider') {
            $result = $this->get('url, key, type, id', $this->tb_api_providers, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        if ($option['task'] == 'item-new-update') {
            $order_log =  "Order ID - ". $params['order_id'];
            if (!$params['response']) {
                $data_item = [
                    "status"      => 'error',
                    "note"        => 'Troubleshooting API requests',
                    "changed"     => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $params['order_id']]);
            }
            if (isset($params['response']['error'])) {
                $order_log .= " : ". $params['response']['error'];
                $data_item = [
                    "status"      => 'error',
                    "note"        => $params['response']['error'],
                    "changed"     => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $params['order_id']]);
            }
            if (isset($params['response']['order'])) {
                $data_item = [
                    "api_order_id" => $params['response']['order'],
                    "changed"      => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $params['order_id']]);
            }
            echo $order_log . '<br>';
        }

        // For single Order
        if ($option['task'] == 'item-status') {
            $item = $params['item'];
            $order_log =  "Order ID - ". $item['id'];

            if (isset($params['response']['error'])) {
                $order_log .= " : ". $params['response']['error'];
                $data_item = [
                    "status"      => 'error',
                    "note"        => $params['response']['error'],
                    "changed"     => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }

            if (isset($params['response']['status'])) {
                $order_log .= " : ". $params['response']['status'];
                $received_status = order_status_format($params['response']['status']);

                $rand_time = get_random_time();
                $data_item = array(
                    "start_counter" => $params['response']['start_count'],
                    "remains"       => order_remains_format($params['response']['remains']),
                    "note" 	        => "",
                    "changed"       => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
                    "status"        => $received_status,
                );
                if (in_array($received_status, ['refunded', 'partial', 'canceled'])) {
                    $new_order_attr = calculate_order_by_status($item, ['status' => $received_status, 'remains' => $params['response']['remains']]);
                    $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $new_order_attr['refund_money']], ['task' => 'update-balance']);
                    $data_item['charge']        = $new_order_attr['real_charge'];
                    $data_item['formal_charge'] = $new_order_attr['formal_chagre'];
                    $data_item['profit']        = $new_order_attr['profit'];
                }
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }
            echo $order_log . '<br>';
        }

        // For single dripfeed Order
        if ($option['task'] == 'item-dripfeed-status') {
            $item = $params['item'];
            $order_log =  "Order ID - ". $item['id'];
            if (isset($params['response']['error'])) {
                $order_log .= " : ". $params['response']['error'];
                $data_item = [
                    "status"      => 'error',
                    "note"        => $params['response']['error'],
                    "changed"     => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }

            if (isset($params['response']['status'])) {
                $order_log .= " : ". $params['response']['status'];
                $rand_time = get_random_time();
                $status_dripfeed = order_status_format($params['response']['status'], 'dripfeed');
                $data_item = [
                    "changed"  => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
                    "status"   => $status_dripfeed,
                ];
                if (isset($params['response']['runs'])) {
                    $data_item['sub_response_orders'] = json_encode((object)$params['response']);
                }else{
                    switch ($params['response']['status']) {
                        case 'Completed':
                            $params['response']['status'] = 'Completed';
                            $params['response']['runs']   = $item['runs'];
                            break;

                        case 'In progress':
                            $params['response']['status'] = 'Inprogress';
                            $params['response']['runs']   = 0;
                            break;

                        case 'Canceled':
                            $params['response']['status'] = 'Canceled';
                            $params['response']['runs']   = 0;
                            break;
                    }
                    $data_item['sub_response_orders'] = json_encode((object)$params['response']);
                }
                /*----------  Add new order from reponse Drip-feed Service data  ----------*/
                if (isset($params['response']['orders'])) {
                    $this->create_order_log($params, ['task' => 'dripfeed']);
                }
                // Return back to user balance
                if (in_array($params['response']['status'], ['Partial', 'Canceled'])) {
                    $charge = $item['charge'];
                    $data_item['quantity'] = 0;
                    $data_item['charge']   = 0;
                    $return_funds = $charge;

                    if ($params['response']['status'] == "Partial") {
                        $return_funds     = $charge - ($charge * ($params['response']['runs'] / $item['runs']));
                        $data_item['quantity'] = $params['response']['runs']  * $item['dripfeed_quantity'];
                        $data_item['charge']   = $charge * ($params['response']['runs']  / $item['runs']);
                    }
                    $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $return_funds], ['task' => 'update-balance']);
                }
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }
            echo $order_log . '<br>';
        }

        // For single dripfeed Order
        if ($option['task'] == 'item-subscriptions-status') {
            $item = $params['item'];
            $order_log =  "Order ID - ". $item['id'];
            if (isset($params['response']['error'])) {
                $order_log .= " : ". $params['response']['error'];
                $data_item = [
                    "status"      => 'error',
                    "note"        => $params['response']['error'],
                    "changed"     => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }
            
            if (isset($params['response']['status'])) {
                $order_log .= " : ". $params['response']['status'];
                $data_item = array(
                    "status"        		    => order_status_format($params['response']['status'], 'subscriptions'),
                    "sub_status"        		=> $params['response']['status'],
                    "sub_response_orders" 	    => json_encode((object)$params['response']),
                    "sub_response_posts" 	    => $params['response']['posts'],
                    "note" 	                    => "",
                    "changed"           		=> date('Y-m-d H:i:s', strtotime(NOW) + get_random_time()),
                );
                /*----------  Add new order from reponse Drip-feed Service data  ----------*/
                if (isset($params['response']['orders'])) {
                    $this->create_order_log($params, ['task' => 'subscriptions']);
                }
                // Return back to user balance if Expired, Canceled
                if (in_array($params['response']['status'], ['Expired', 'Canceled', 'Paused'])) {
                    $return_funds = $item['charge'];
                    if (in_array($params['response']['status'], ['Expired', 'Paused'])) {
                        $return_funds  = $item['charge'] * (1 - ((int)$params['response']['posts'] / $item['sub_posts']));
                        $data_item['charge']   = $item['charge'] - $return_funds;
                    } else {
                        $data_item['charge'] = 0;
                    }
                    $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $return_funds], ['task' => 'update-balance']);
                }
                $this->db->update($this->tb_main, $data_item, ["id" => $item['id']]);
            }
            echo $order_log . '<br>';
        }

    }

    private function create_order_log($params = [], $option = [])
    {
        $item        = $params['item'];
        $item_api    = $params['item_api'];
        $db_orders = json_decode($item['sub_response_orders']);
        $new_orders   = [];
        if (isset($db_orders->orders)) {
            $new_orders = array_diff($params['response']['orders'], $db_orders->orders);
        }else{
            $new_orders = $params['response']['orders'];
        }
        if (empty($new_orders)) return false;
        $data_orders_batch = [];
        foreach ($new_orders as $order_id) {
            $exists_order = $this->get('id', $this->tb_main, ['api_order_id' => $order_id, 'service_id' => $item['service_id'], 'api_provider_id' => $item['api_provider_id']]);
            if (!empty($exists_order)) continue;
            $data_order = [
                "ids" 	        	  => ids(),
                "uid" 	        	  => $item['uid'],
                "cate_id" 	    	  => $item['cate_id'],
                "service_id" 		  => $item['service_id'],
                "main_order_id"       => $item['id'],
                "service_type" 		  => "default",
                "api_provider_id"  	  => $item['api_provider_id'],
                "api_service_id"  	  => $item['api_service_id'],
                "api_order_id"  	  => $order_id,
                "status"  	          => 'pending',
                "changed" 	    	  => NOW,
                "created" 	    	  => NOW,
            ];

            if ($option['task'] == 'dripfeed') {
                $data_order['link']          = $item['link'];
                $data_order['quantity']      = $item['dripfeed_quantity'];
                $data_order['charge']        = ($item['charge'] * $item['dripfeed_quantity']) / $item['quantity'];;
                $data_order['formal_charge'] = ($item['formal_charge'] * $item['dripfeed_quantity']) / $item['quantity'];
                $data_order['profit']        = ($item['profit'] * $item['dripfeed_quantity']) / $item['quantity'];
            }

            if ($option['task'] == 'subscriptions') {
                $data_order['link']          = "https://www.instagram.com/". $item['username'];
                $data_order['quantity']      = $item['sub_max'];
                $data_order['charge']        = $item['charge'] / $item['sub_posts'];
                $data_order['formal_charge'] = $item['formal_charge'] / $item['sub_posts'];
                $data_order['profit']        = $item['profit'] / $item['sub_posts'];
            }

            $data_orders_batch[] = $data_order;
        }
        if (!empty($data_orders_batch)) {
            $this->db->insert_batch($this->tb_main, $data_orders_batch);
            return true;
        }
    }
}
