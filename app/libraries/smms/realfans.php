<?php 
  class smm_realfans {
    public $api_url;
    public $api_key;
    public $ci;

    public function __construct($api = ""){
      $this->api_url = $api->url. '?';
      $this->api_key = $api->key;
      $this->ci      = &get_instance();
    }

    public function order($data_post) {
      $data = [
        'key'     => $this->api_key,
        'action'  => 'add',
        'service' => $data_post['service'],
        'amount'  => $data_post['quantity'],
        'link'    => $data_post['link'],
      ];
      
      if( isset($data_post['comments'])){
        $data['custom_comments'] = base64_encode(implode("\n", $data_post['comments']));
      }
      return json_decode($this->connect($data));
      
    }

    public function status($order_id) { 
      return json_decode($this->connect(array(
        'key'    => $this->api_key,
        'action' => 'status',
        'order'  => $order_id
      )));
    }

    public function groups() { 
      return json_decode($this->connect(array(
        'key'    => $this->api_key,
        'action' => 'groups',
      )));
    }

    public function categories($group_id) { 
      return json_decode($this->connect(array(
        'key'         => $this->api_key,
        'action'      => 'services',
        'group_id'    => $group_id,
      )));
    }

    public function products($service_id){
      $products =  json_decode($this->connect(array(
        'key'         => $this->api_key,
        'action'      => 'products',
        'service_id'    => $service_id,
      )));

      if(is_array($products) && !empty($products)){
        return $products;
      }else{
        return false;
      }
    } 

    public function services() { 
      $groups = $this->groups();
      if(!$groups){
        return false;
      }
      $cates = [];
      $services = [];
      foreach ($groups as $key => $group) {
        $cate_tmp = $this->categories($group->group_id);
        if ($cate_tmp) {
          $cates = array_merge($cates, $cate_tmp);
        }
      }
      return $cates;
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
