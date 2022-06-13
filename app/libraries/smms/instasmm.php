<?php
// https://instasmmpanel.com
class smm_instasmm {
    // const apiUrl = 'https://instasmmpanel.com/api';		// API URL
    // const apiKey = '8f8172d84ca5ea834464e6d97cedb08f';						// API KEY

    public $api_url;
    public $api_key;
    public $ci;

    public function __construct($api = ""){
        $this->api_url = $api->url;
        $this->api_key = $api->key;
        $this->ci      = &get_instance();
    }

    public function addOrder($data_post) {
        $params = array(
            'apiKey'        => $this->api_key,
            'actionType'    => 'add',
            'orderType'     => $data_post['service'],
            'orderUrl'      => $data_post['link'],
            'orderQuantity' => $data_post['quantity']
        );
        $result = self::Connect($params);
        return $result;
    }

    public function orderStatus($orderID) {
        $params = array(
            'apiKey'     => $this->api_key,
            'actionType' => 'status',
            'orderID'    => $orderID
        );
        $result = self::Connect($params);
        return $result;
    }

    public function services() {
        $params = array(
            'apiKey'     => $this->api_key,
            'actionType' => 'services',
        );
        $result = self::Connect($params);
        return $result;
    }
    
    public function balance() {
        $params = array(
            'apiKey'     => $this->api_key,
            'actionType' => 'balance',
        );
        $result = self::Connect($params);
        return $result;
    }


    private function Connect($params) {

        $post = array();
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $post[] = $key.'='.urlencode($value);
            }
        }
		
        $c = curl_init();
		
        curl_setopt($c, CURLOPT_URL, $this->api_url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, join('&', $post));
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($c, CURLOPT_TIMEOUT, 10);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($c, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows; U; Windows NT 6.1; tr; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $contents = curl_exec($c);
		curl_close($c);
		if ($contents) return json_decode($contents);
        else return FALSE;
    }
}

