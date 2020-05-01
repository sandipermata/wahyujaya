<?php

require_once('Base.php');

class Area {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function getProvince(){
    $sql = "SELECT prov_code, prov_name, prov_image FROM tb_province ORDER BY prov_name";
    return $this->func->db_execute($sql);
  }

  public function getCity($prov){
    return $this->func->select_where("tb_city", null, array("prov_provcode" => $prov ));
  }

  public function getDistrict($city){
    return $this->func->select_where("tb_district", null, array("city_city_code" => $city ));
  }



}

?>