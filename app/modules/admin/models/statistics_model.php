<?php

use function GuzzleHttp\json_decode;

defined('BASEPATH') OR exit('No direct script access allowed');

class statistics_model extends MY_Model 
{

    protected $tb_main;
    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = '';

        $this->chart_spline_limit_days = 7;
        $this->no_last_days = 30;
        $this->currency_symbol = get_option('currency_symbol', "$");
    }

    public function header_statistics()
    {
        $total_users                = $this->count_results('id', $this->tb_users, ['status' => 1]);
        $total_transactions         = $this->sum_results('amount', $this->tb_transaction_logs, ['status' => 1]);
        $total_orders               = 0;
        $total_tickets              = $this->count_results('id', $this->tb_tickets);
        $total_providers_balance    = $this->sum_results('balance', $this->tb_api_providers, ['status' => 1]);
        $total_users_balance        = $this->sum_results('balance', $this->tb_users, ['status' => 1]);

        $profit_data_last_30_day = $this->profit_calculate(30);
        $profit_today               = 0;
        $profit_30_days             = 0;
        if ($profit_data_last_30_day) {
            $profit_today   = end($profit_data_last_30_day);
            $profit_30_days = array_sum($profit_data_last_30_day);
        }
        $result = [
            'users' => [
                'name'    =>  'Total Users',
                'value'   =>  $total_users,
                'class'   =>  'bg-success-gradient',
                'icon'    =>  'fe  fe-users'],
            'transactions' => [
                'name'    => 'Total amount received', 
                'value'   => $this->currency_symbol . currency_format($total_transactions),
                'class'   => 'bg-info-gradient',
                'icon'    => 'fe fe-dollar-sign'],
            'orders' => [
                'name'    => 'Total  Orders',
                'value'   => $total_orders,
                'class'   => 'bg-warning-gradient',
                'icon'    => 'fe fe-shopping-cart'],
            'tickets'  => [
                'name'    => 'Total  tickets',
                'value'   => $total_tickets,
                'class'   => 'bg-danger-gradient',
                'icon'    => 'fa fa-ticket'],
            'providers_balance' => [
                'name'    => "Total  Users' Balance",
                'value'   => $this->currency_symbol . currency_format($total_users_balance),
                'class'   =>  'bg-success-gradient',
                'icon'    => 'icon-fa fa fa-money'],
            'users_balance'     => [
                'name'    => "Total  Providers'  balance",
                'value'   => $this->currency_symbol . currency_format($total_providers_balance),
                'class'   =>  'bg-info-gradient', 
                'icon'    => 'icon-fa fa fa-balance-scale'],
            'profit_today'  => [
                'name'    => 'Total  Profit  Today',   
                'value'   => $this->currency_symbol . currency_format($profit_today),
                'class'   =>  'bg-warning-gradient', 
                'icon'    => 'icon-fa fa fa-calculator'],
            'profit_30_days'  => [
                'name'    => 'Total  Profit  30  days',
                'value'   => $this->currency_symbol . currency_format($profit_30_days),
                'class'   =>  'bg-danger-gradient', 
                'icon'    => 'icon-fa fa fa-calculator'],
        ];
        return $result;
    }

    public function chart_and_orders_statistics()
    {

        $data_pie = $this->data_chart_pie();
        $result = [
            'chart_spline'         => $this->replace_data_language($this->data_chart_spline()),
            'chart_pie'            => $this->replace_data_language(json_encode($data_pie)),
            'orders_statistics'    => $this->orders_statistics($data_pie),
        ];
        
        return $result;
    }

    private function orders_statistics($data_orders_statistics = [])
    {
        $total_orders                   = array_sum($data_orders_statistics);
        $total_completed                = (isset($data_orders_statistics['completed'])) ? $data_orders_statistics['completed'] : 0;
        $total_processing               = (isset($data_orders_statistics['processing'])) ? $data_orders_statistics['processing'] : 0;
        $total_inprogress               = (isset($data_orders_statistics['inprogress'])) ? $data_orders_statistics['inprogress'] : 0;
        $total_pending                  = (isset($data_orders_statistics['pending'])) ? $data_orders_statistics['pending'] : 0;
        $total_partial                  = (isset($data_orders_statistics['partial'])) ? $data_orders_statistics['partial'] : 0;
        $total_cancelled                = (isset($data_orders_statistics['canceled'])) ? $data_orders_statistics['canceled'] : 0;
        $total_refunded                 = (isset($data_orders_statistics['refunded'])) ? $data_orders_statistics['refunded'] : 0;

        $result = [
            'orders' => [
                'name'    =>  'Total Orders',
                'value'   =>  $total_orders,
                'class'   =>  'bg-success-gradient',
                'icon'    =>  'fe fe-list'],
            'completed' => [
                'name'    => 'Completed', 
                'value'   => $total_completed,
                'class'   => 'bg-info-gradient',
                'icon'    => 'fe fe-check'],
            'processing' => [
                'name'    => 'Processing',
                'value'   => $total_processing,
                'class'   => 'bg-warning-gradient',
                'icon'    => 'fe fe-trending-up'],
            'inprogress'  => [
                'name'    => 'In progress',
                'value'   => $total_inprogress,
                'class'   => 'bg-danger-gradient',
                'icon'    => 'fe fe-loader'],
            'pending' => [
                'name'    => "Pending",
                'value'   => $total_pending,
                'class'   =>  'bg-success-gradient',
                'icon'    => 'fe fe-pie-chart'],
            'partial'     => [
                'name'    => "Partial",
                'value'   => $total_partial,
                'class'   =>  'bg-info-gradient', 
                'icon'    => 'fa fa-hourglass-half'],
            'canceled'  => [
                'name'    => 'Canceled',   
                'value'   => $total_cancelled,
                'class'   =>  'bg-warning-gradient', 
                'icon'    => 'fe fe-x-square'],
            'refunded'  => [
                'name'    => 'Refunded',
                'value'   => $total_refunded,
                'class'   =>  'bg-danger-gradient', 
                'icon'    => 'fe fe-rotate-ccw'],
        ];
        return $result;
    }

    private function profit_calculate($number_days){
        $params = [
            'select'   		=> 'DATE(changed) as time, SUM(`profit`) as total_profit',
            'group_by' 		=> ['DATE(changed)'],
            'where'         => ['changed >' => date('Y-m-d', strtotime('-' . $number_days . ' days'))],
            'data_type'     => 'array',
        ];
        $result = $this->data_for_analytic( $params, ['task' => 'profit-last-days'] );
        if(!empty($result)){
            $result = array_column($result, 'total_profit', 'time');
        }
        return $result;
    }
    /*----------  Get array data_chart_pie  ----------*/
    private function data_chart_pie(){
        $params = [
            'select'   		=> 'status, count(id) as total',
            'group_by' 		=> ['status'],
            'data_type'     => 'array',
        ];
        $data_for_analytic = $this->data_for_analytic( $params, ['task' => 'chart-pie'] );
        if($data_for_analytic){
            $data_for_analytic_new = array_column($data_for_analytic, 'total', 'status');
        };
        $data_chart_pie =  [
            "completed"  		=> ( array_key_exists('completed', $data_for_analytic_new) ) ? $data_for_analytic_new['completed'] : 0,
            "processing"   		=> ( array_key_exists('processing', $data_for_analytic_new) ) ? $data_for_analytic_new['processing'] : 0,
            "canceled"    		=> ( array_key_exists('canceled', $data_for_analytic_new) ) ? $data_for_analytic_new['canceled'] : 0,
            "pending"    		=> ( array_key_exists('pending', $data_for_analytic_new) ) ? $data_for_analytic_new['pending'] : 0,
            "partial"    		=> ( array_key_exists('partial', $data_for_analytic_new) ) ? $data_for_analytic_new['partial'] : 0,
            "inprogress"    	=> ( array_key_exists('inprogress', $data_for_analytic_new) ) ? $data_for_analytic_new['inprogress'] : 0,
        ];
        return $data_chart_pie;
    }

    /*----------  Get array data_chart_spline  ----------*/
    private function data_chart_spline($params = null, $option = null)
    {
        $orders_status = ["completed", "processing", "canceled", "pending", "partial", "inprogress"];

        $params = [
            'select'   		=> 'status, count(id) as total, DATE(changed) as datetime',
            'group_by' 		=> ['status', 'DATE(changed)'],
            'data_type'     => 'object',
            'where'         => ['changed >' => date('Y-m-d', strtotime('-' . $this->chart_spline_limit_days . ' days'))],
        ];
        $data_for_analytic = $this->data_for_analytic( $params, ['task' => 'chart-spline'] );

        //Create data format
        for ($i = $this->chart_spline_limit_days; $i >= 1 ; $i--) { 
            $data_time[ date('Y-m-d', strtotime(NOW) - 86400 * ($i - 1)) ] = 0;
        }
        $default_data_format = [];
        foreach ($orders_status as $value) {
            $default_data_format[$value] = $data_time;
        }
        if($data_for_analytic){
            foreach ($data_for_analytic  as $key => $row) {
                if( isset($default_data_format[ $row->status ]) && isset( $default_data_format[$row->status][$row->datetime] ) ){
                    $default_data_format[$row->status][$row->datetime] = $row->total;
                }
            }

        };
        $data_orders_chart_spline = [
            'time' => array_keys($data_time),
        ];
        foreach($default_data_format  as $key => $row){
            $data_orders_chart_spline[$key] = array_values($row);
        }
        return json_encode($data_orders_chart_spline);
    }

    private function data_for_analytic($params = null, $option = null){
        $result = [];
        $this->db->select( $params['select'] );
        $this->db->from($this->tb_order);

        if($option['task'] == 'chart-spline' || $option['task'] == 'chart-spline-total-orders' ){
            $this->db->where( $params['where'] );
        }
        if($option['task'] == 'profit-last-days'){
            $this->db->where( $params['where'] );
            $this->db->where_in('status', ['completed', 'partial']);
        }
        $this->db->group_by( $params['group_by'] );

        $query  = $this->db->get();
        switch ($params['data_type']) {
            case 'array':
                $result = $query->result_array();
                break;
            
            default:
            $result = $query->result();
                break;
        }
        return $result;
    }

    private function replace_data_language($string){
        $data_new_lang = [
            "completed" 	=> 'Completed',
            "processing" 	=> 'Processing',
            "inprogress" 	=> 'In progress',
            "pending" 		=> 'Pending',
            "partial" 		=> 'Partial',
            "canceled" 		=> 'Canceled',
        ];
        foreach ($data_new_lang as $key => $value) {
            $string 	= str_replace($key, $value, $string);
        }
        return $string;
    }
}
