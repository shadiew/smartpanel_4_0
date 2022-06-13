<?php 
  class smm_yoyomedia {
    public $api_url;
    public $api_key;
    public $ci;

    public function __construct($api = ""){
        $this->api_url = $api->url;
        $this->api_key = $api->key;
        $this->ci      = &get_instance();
    }
    public function order($data_post) {
      return json_decode($this->connect(array(
        'key'    => $this->api_key,
        'action' => 'add',
        'type'   => $data_post['service'],
        'amount' => $data_post['quantity'],
        'link'   => $data_post['link']
      )));
    }

    public function status($order_id) { 
      return json_decode($this->connect(array(
        'key'    => $this->api_key,
        'action' => 'status',
        'order'  => $order_id
      )));
    }

    public function services() { 
      return json_decode($this->connect(array(
        'key'    => $this->api_key,
        'action' => 'services',
      )));
    }

    public function balance() {
      return json_decode($this->connect(array(
        'key' => $this->api_key,
        'action' => 'balance',
      )));
    }

    private function connect($post) {
      $_post = Array();
      if (is_array($post)) {
        foreach ($post as $name => $value) {
          $_post[] = $name.'='.$value;
        }
      }
      
      if (is_array($post))
      {
        $url_complete = join('&', $_post);
      }
      
      $url = $this->api_url.$url_complete;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_USERAGENT, 'API (compatible; MSIE 5.01; Windows NT 5.0)');
      $result = curl_exec($ch);
      if (curl_errno($ch) != 0 && empty($result))
      {
        $result = false;
      }
      curl_close($ch);
      return $result;
    }
  }
