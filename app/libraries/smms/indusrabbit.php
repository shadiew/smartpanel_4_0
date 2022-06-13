<?php

class smm_indusrabbit {
    public $api_url;
    public $api_key;
    public $ci;

    public function __construct($api_url, $api_key){
        $this->api_url = $api_url;
        $this->api_key = $api_key;
        $this->ci      = &get_instance();
    }

    public function order($data_post) { 
        $data = array(
            'package' => $data_post['service'],
            'link'    => $data_post['link']
        );

        if (isset($data_post['comments'])) {
            $data['custom_data'] = $data_post['comments'];
            $quantity = explode("\n", $data_post['comments']);
            $data['quantity'] = count($quantity);
        }else{
            $data['quantity']  = $data_post['quantity'];
        }

        $post = array_merge([
            'api_token' => $this->api_key,
            'action'    => 'add'
        ], $data);

        return json_decode($this->connect($post));
    }

    public function status($order_id) { // get order status
        return json_decode($this->connect([
            'api_token' => $this->api_key,
            'action'    => 'status',
            'order'     => $order_id
        ]));
    }

    public function balance() { // get balance
        return json_decode($this->connect([
            'api_token' => $this->api_key,
            'action'    => 'balance',
        ]));
    }

    public function packages() { // get packages list
        return json_decode($this->connect([
            'api_token' => $this->api_key,
            'action'    => 'packages',
        ]));
    }

    private function connect($post) {
        $_post = Array();
        foreach ($post as $name => $value) {
            $_post[$name] = urlencode($value);
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}

