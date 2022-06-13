<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class plugins_model extends MY_Model 
{
    protected $tb_main;
    protected $path_file;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main         = PURCHASE;
        $this->path_file = base64_decode('aW5zdGFsbC5zcWw=');
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;

        // List items for user add funds
        if ($option['task'] == 'list-items') {
            $result = $this->fetch("*", $this->tb_main, '', '', '', false);
        }

        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;

        if($option['task'] == 'get-item-main'){
            $result = $this->get("*", $this->tb_main, ['id' => $params['id']], '', '', true);
        }

        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'install-upgrade-item'){
            $item_data = $params['item_data'];
            $path_file = $this->path_file;
            if (file_exists($path_file)) {
                $sql = file_get_contents($path_file);
                $sqls = explode(';', $sql);
                array_pop($sqls);
                foreach($sqls as $statement){
                    $statment = $statement . ";";
                    $this->db->query($statement);
                }
                @unlink($path_file);
            }
            $item = $this->get("*", $this->tb_main, ['pid' => $item_data[0]]);
            $item_crud_data = array(
                "ids"           => ids(),
                "pid"           => $item_data[0],
                "purchase_code" => $params['code'],
                "version"       => $item_data[3]
            );
            if(empty($item)){
                $this->db->insert($this->tb_main, $item_crud_data);
            }else{
                $this->db->update($this->tb_main, $item_crud_data, array("id" => $item->id));
            }
            $result = ["status" 	=> "success", "message"   => "Installation successfully"];
        }
        return $result;
    }
}
