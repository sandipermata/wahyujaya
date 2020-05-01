<?php

require_once('Base.php');

class Icon {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function get(){
    $sql = "SELECT icon_category FROM tb_icons GROUP BY icon_category";
    $main = $this->func->db_execute($sql);

    foreach ($main['data'] as $key => $value) {
      $sql2 = "SELECT icon_id, icon_name, icon_image FROM tb_icons WHERE icon_category = '" .  $value['icon_category'] .  "' ORDER BY icon_name ";
      $sub = $this->func->db_execute($sql2);
      $main['data'][$key]['data_child'] = $sub['data'];
    }
    return $main;
  }

  public function getId($id){
    return $this->func->select_where("tb_icons", null, array("icon_id" => $id ) );
  }

  public function getType($id){
    return $this->func->select_where("tb_icons", null, array("icon_category" => $id));
  }

  public function save($post){
    $check = $this->func->select_where("tb_icons", null, array("AND" => array("icon_category" => $post['icon_category'], "icon_type" => $post['icon_type'] ) ));
    if(count($check['data']) > 0){
      $put = $this->func->db_update("tb_icons", $post, array('icon_id' => $check['data'][0]['icon_id'] ));
      $result = $put;
    }else{
      $insert = $this->func->db_insert("tb_icons", $post);
      $result = $insert;
    }
    return $result;
  }

  public function update($post){
    return $this->func->db_update("tb_icons", $post, array('icon_id' => $post['icon_id'] ));
  }

  public function delete($id){
    return $this->func->db_delete("tb_icons", array("icon_id" => $id ));
  }


}

?>