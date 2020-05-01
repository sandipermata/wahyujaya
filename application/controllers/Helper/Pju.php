<?php

require_once('Base.php');

class Pju {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function get(){
    $sql = "SELECT pju_ip, pju_area FROM tb_pju GROUP BY pju_ip";
    $main = $this->func->db_execute($sql);

    foreach ($main['data'] as $key => $value) {
      $sql2 = "SELECT pju_id, pju_pole, pju_loc_lat, pju_loc_lon, pju_loc_desc, pju_duration
              FROM tb_pju WHERE pju_ip = '" .  $value['pju_ip'] .  "' ORDER BY pju_pole ";
      $sub = $this->func->db_execute($sql2);
      $main['data'][$key]['data_child'] = $sub['data'];
    }
    return $main;
  }

  public function getId($id){
    return $this->func->select_where("tb_pju", null, array("pju_id" => $id ) );
  }

  public function save($post){
    return $this->func->db_insert("tb_pju", $post);
  }

  public function update($post){
    return $this->func->db_update("tb_pju", $post, array('pju_id' => $post['pju_id'] ));
  }

  public function delete($id){
    return $this->func->db_delete("tb_pju", array("pju_id" => $id ));
  }


}

?>