<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class provider_model extends MY_Model 
{

    protected $tb_main;
    protected $tb_services;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = API_PROVIDERS;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['default'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('id, ids, name, url, key, status, description, created, balance, currency_code');
            $this->db->from($this->tb_main);

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('id', 'ASC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }

            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'list-items-in-import-services') {
            $result = $this->fetch("id, ids, name", $this->tb_main, ['status' => 1], '', '', '', '', true);
        }
        
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $result = $this->get("id, ids, name, url, key, type, status, description, created, balance, currency_code", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(id) as count, status');
            $this->db->from($this->tb_main);
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('status', 'DESC');
            $this->db->group_by('status');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('id');
            $this->db->from($this->tb_main);
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }

    public function delete_item($params = null, $option = null)
    {
        $result = [];
        if($option['task'] == 'delete-item'){
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["id" => $params['id']]);
                $this->db->delete($this->tb_services, ["cate_id" => $params['id']]);
                $result = [
                    'status' => 'success',
                    'message' => 'Deleted successfully',
                    "ids"     => $item->ids,
                ];
            }else{
                $result = [
                    'status' => 'error',
                    'message' => 'There was an error processing your request. Please try again later',
                ];
            }
        }
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        switch ($option['task']) {
            case 'add-item':
                $data = [
                    "ids"             => ids(),
                    "name"            => post("name"),
                    "status"          => (int)post("status"),
                    "key"             => post("key"),
                    "url"             => post("url"),
                    "description"     => post("description"),
                    "balance"         => $params['balance'],
                    "created"         => NOW,
                    "changed"         => NOW,
                ];

                $this->db->insert($this->tb_main, $data);
                return ["status"  => "success", "message" => 'Add successfully'];
                break;

            case 'edit-item':
                $data = [
                    "name"            => post("name"),
                    "status"          => (int)post("status"),
                    "key"             => post("key"),
                    "url"             => post("url"),
                    "description"     => post("description"),
                    "balance"         => $params['balance'],
                    "changed"         => NOW,
                ];
                $this->db->update($this->tb_main, $data, ["id" => post('id')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'balance-item':
                $data = [
                    "balance"         => $params['balance'],
                    "changed"         => NOW,
                ];
                $this->db->update($this->tb_main, $data, ["id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status'], 'changed' => NOW], ["id" => $params['id']]);
                // Related Service
                if (!$params['status']) {
                    $this->db->where_in('api_provider_id', $params['id']);
                    $this->db->update($this->tb_services,  ['status' => 0]);
                }
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'delete':
                        // Category
                        $this->db->where_in('id', $arr_ids);
                        $this->db->delete($this->tb_main);

                        // Related Service
                        $this->db->where_in('api_provider_id', $arr_ids);
                        $this->db->delete($this->tb_services);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'deactive':
                        // Category
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);

                        // Related Services
                        $this->db->where_in('api_provider_id', $arr_ids);
                        $this->db->update($this->tb_services,  ['status' => 0]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }

    public function crud_services($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'import-services-by-cate-id') {
            $api_services               = array_sort_by_new_key($params['items_provider_service'], 'service');
            $api_service_ids_insert_arr = array_intersect_key($api_services, array_flip($params['service_ids']));
            $data_services_insert_batch = [];
            if ($api_service_ids_insert_arr) {
                foreach ($api_service_ids_insert_arr as $key => $item) {
                    //Check duplicate Service
                    $check_item = $this->get("id", $this->tb_services, ['api_provider_id' => $params['api_id'], 'api_service_id' => $item['service']]);
                    if ($check_item) continue;
                    
                    $data_services_insert_batch[] = $this->get_crud_data_service($item, $params);
                }    
            }
            if ($data_services_insert_batch) {
                $this->db->insert_batch($this->tb_services, $data_services_insert_batch); 
            }
            $result = ["status"  => "success", "message" => 'Import Services successfully'];
        }

        if ($options['task'] == 'bulk-import-service') {
            $api_services = array_sort_by_new_key($params['items_provider_service'], 'service');

            if (empty($api_services)) return ["status"  => "error", "message" => 'There seems to be an issue connecting to API provider. Please check API key and Token again!'];
            $this->import_services($api_services, $params);

            $result = ["status"  => "success", "message" => 'Import Services successfully'];
        }

        if ($options['task'] == 'sync-services') {
            if (empty($params['items_provider_service'])) return ["status"  => "error", "message" => 'There seems to be an issue connecting to API provider. Please check API key and Token again!'];

            //Condition to get current service
            $where_get_current_services = ["api_provider_id" => $params['item_provider']['id'], 'status' => 1];
            if ($params['sync_request_options']['old_service_status']) {
                unset($where_get_current_services['status']);
            }
            $services = $this->fetch('id, ids, name, price, api_service_id', $this->tb_services, $where_get_current_services, '', '', '', '', true);

            if (empty($services)) {
                return ["status"  => "error", "message" => 'There is no service related to this provider for this request. Please check the services list again!'];
            }

            $params['services'] = $services;
            $result = $this->sync_services($params);
            return $result;
        }

        return $result;
    }

    /**
     * Create API data Service before inserting , updating to DB
     *
     * @param array $params - arr services, api_services, sync_request_options
     * @return array
     */
    private function sync_services($params)
    {
        $api_services          = array_sort_by_new_key($params['items_provider_service'], 'service');
        $current_services      = array_sort_by_new_key($params['services'], 'api_service_id');

        /*----------  Compare services  ----------*/
        $disabled_services    = array_diff_key($current_services, $api_services);
        $new_services         = array_diff_key($api_services, $current_services);
        $exists_services      = array_diff_key($api_services, $new_services);
        // update status
        if (!empty($disabled_services)) {
            $this->db->where_in('id', array_column($disabled_services, 'id'));
            $this->db->update($this->tb_services, ["status" => 0, "changed" => NOW]);
        }

        // Sync exists services
        if (!empty($exists_services) && !empty($params['sync_request_options'])) {
            $this->sync_exists_services($exists_services, $params);
        }

        // add new services with all 
        if (!empty($new_services) && $params['sync_request_type']) {
            $params['convert_to_new_currency'] = (isset($params['sync_request_options']['convert_to_new_currency'])) ? $params['sync_request_options']['convert_to_new_currency'] : 0;
            unset($params['sync_request_options']);
            unset($params['item_provider']);
            unset($params['items_provider_service']);
            unset($params['services']);
            $result_new_services = $this->import_services($new_services, $params);
        }

        $result = [
            'new_services' 		=> ($params['sync_request_type']) ? $result_new_services : [],
            'exists_services'   => $exists_services,
            'disabled_services' => $disabled_services,
        ]; 
        return $result;
    }

    /**
     * From Ver 3.6
     * import services from input provider data services
     *
     * @param array $params - api_services, sync_request_options
     * @param array $data_services - provider data services need to import 
     * @return array
     */
    private function sync_exists_services($data_services = [], $params = [])
    {
        if (!empty($data_services)) {
            $sync_request_options = $params['sync_request_options'];
            foreach ($data_services as $key => $item) {
                $data_item = [
                    "type"    => service_type_format($item['type']),
                    "changed" => NOW,
                ];
                /*----------  Sync New Price  ----------*/
                if (isset($sync_request_options['new_price']) && $sync_request_options['new_price']) {
                    $price_percentage_increase = (isset($params['price_percentage_increase'])) ? $params['price_percentage_increase'] : get_option("default_price_percentage_increase", 30);
                    $convert_to_new_currency_rate = (isset($sync_request_options['convert_to_new_currency']) && $sync_request_options['convert_to_new_currency']) ? get_option("new_currecry_rate", 1) : 1;
                    $data_item['price'] = import_new_rate($item['rate'], $price_percentage_increase, $convert_to_new_currency_rate);
                }
                /*----------  sync Descriptions  ----------*/
                if (isset($sync_request_options['service_desc']) && $sync_request_options['service_desc']) {
                    if (isset($item['desc']) && $item['desc'] != "") {
                        $data_item['desc'] = $item['desc'];
                    }
                }
                /*----------  sync Servie Name  ----------*/
                if (isset($sync_request_options['service_name']) && $sync_request_options['service_name']) {
                    $data_item['name'] = $item['name'];
                }
                /*----------  Sync Original Price  ----------*/
                if (isset($sync_request_options['original_price']) && $sync_request_options['original_price']) {
                    $data_item['original_price'] = (double)$item['rate'];
                }
                /*---------- Sync  Min Max dripfeed  ----------*/
                if (isset($sync_request_options['min_max_dripfeed']) && $sync_request_options['min_max_dripfeed']) {
                    $data_item['min']      = $item['min'];
                    $data_item['max']      = $item['max'];
                    $data_item['dripfeed'] = (isset($item['dripfeed']) && $item['dripfeed']) ? $item['dripfeed'] : 0;
                }
                /*---------- Old Service status  ----------*/
                if (isset($sync_request_options['old_service_status']) && $sync_request_options['old_service_status']) {
                    $data_item['status']      = 1;
                }
                $this->db->update($this->tb_services, $data_item, ["api_service_id" => $item['service'], "api_provider_id" => $params['api_id']]);
            }
            return true;
        }
        return false;
    }

    /**
     * From Ver 3.6
     * import services from input provider data services
     *
     * @param array $params - api_services, sync_request_options
     * @param array $data_services - provider data services need to import 
     * @return array
     */
    private function import_services($data_services = [], $params = [], $task = 'bulk-import-service')
    {
        $result = [];
        if (!empty($data_services)) {
            $i = 0;
            foreach ($data_services as $key => $item) {
                $import_limit = (isset($params['limit'])) ? $params['limit'] : 'all';
                if ($i <= $import_limit || $import_limit == 'all') {
                    
                    $check_item = $this->get("id", $this->tb_services, ['api_provider_id' => $params['api_id'], 'api_service_id' => $item['service']], '', '', true);
                    if ($check_item) continue;

                    // add new
                    $check_category = $this->get("id", $this->tb_categories, ['name' => trim($item['category'])], '', '', true);
                    $params['cate_id'] = '';
                    if ($check_category) {
                        $params['cate_id'] = $check_category['id'];
                    } else {
                        $data_category = array(
                            "ids"  			  => ids(),
                            "name"            => trim($item['category']),
                            "sort"            => $i,
                            "changed"         => NOW,
                            "created"         => NOW,
                        );
                        $this->db->insert($this->tb_categories, $data_category);
                        if ($this->db->affected_rows() > 0) {
                            $params['cate_id'] = $this->db->insert_id();
                        }
                    }
                    $data_item = $this->get_crud_data_service($item, $params);
                    $this->db->insert($this->tb_services, $data_item);
                    $result[] = array_merge($data_item, ['id' => $this->db->insert_id()]);
                    $i++;
                }
            }
        }
        return $result;
    }

    /**
     * Create API data Service before inserting , updating to DB
     *
     * @param array $service
     * @param array $params - api_id, cate_id, price_percentage_increase, etc
     * @return array
     */
    private function get_crud_data_service($service = [], $params = [], $task = 'add')
    {
        $data_item = [];
        $add_type = (isset($params['api_id'])) ? 'api' : 'manual';
        $price_percentage_increase = (isset($params['price_percentage_increase'])) ? $params['price_percentage_increase'] : get_option("default_price_percentage_increase", 30);
        $convert_to_new_currency_rate = (isset($params['convert_to_new_currency']) && $params['convert_to_new_currency']) ? get_option("new_currecry_rate", 1) : 1;
        switch ($task) {
            case 'update':
                $data_item = [
                    "min"             	=> $service['min'],
                    "max"             	=> $service['max'],
                    "price"           	=> import_new_rate($service['rate'], $price_percentage_increase, $convert_to_new_currency_rate),
                    "original_price"    => (double)$service['rate'],
                    "type"        	    => service_type_format($service['type']),
                    "dripfeed"  	    => (isset($service['dripfeed'])) ? (int)$service['dripfeed'] : 0,
                    "desc"  	        => (isset($service['desc'])) ? $service['desc'] : '',
                    "refill"  	        => (isset($service['refill'])) ? (int)$service['refill'] : 0,
					"refill_type"  	    => (isset($service['refill'])) ? (int)$service['refill'] : 0,
                ];
                break;
            
            default:
                $data_item = [
                    "ids"  				=> ids(),
                    "name"            	=> $service['name'],
                    "cate_id"           => $params['cate_id'],
                    "min"             	=> $service['min'],
                    "max"             	=> $service['max'],
                    "price"           	=> import_new_rate($service['rate'], $price_percentage_increase, $convert_to_new_currency_rate),
                    "original_price"    => (double)$service['rate'],
                    "add_type"        	=> $add_type,
                    "type"        	    => service_type_format($service['type']),
                    "api_provider_id"  	=> $params['api_id'],
                    "api_service_id"  	=> $service['service'],
                    "dripfeed"  	    => (isset($service['dripfeed'])) ? (int)$service['dripfeed'] : 0,
                    "desc"  	        => (isset($service['desc'])) ? $service['desc'] : '',
                    "refill"  	        => (isset($service['refill'])) ? (int)$service['refill'] : 0,
					"refill_type"  	    => (isset($service['refill'])) ? (int)$service['refill'] : 0,
                    "status"  			=> 1,
                    "changed"  			=> NOW,
                    "created"  			=> NOW,
                ];
                break;
        }
        return $data_item;
    }
}
