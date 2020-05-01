<?php

require_once('Base.php');

class Admin {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function getAllUser(){
    return $this->func->select_all("tb_admin");
  }

  public function getLogin($user, $pass){
    return $this->func->select_where("tb_admin", null, array("AND" => array('adm_code' => $user, 'adm_pass' => $pass ) ));
  }

  public function getUserId($id){
    return $this->func->select_where("tb_admin", null, array("adm_code" => $id ) );
  }

  public function saveUser($post){
    return $this->func->db_insert("tb_admin", $post);
  }

  public function updateUser($post){
    return $this->func->db_update("tb_admin", $post, array('adm_code' => $post['adm_code'] ));
  }

  public function deleteUser($id){
    $hasil = $this->func->db_delete("tb_admin", array("adm_code" => $id ));
    if($hasil['code'] == "200" ){
      $this->func->db_delete("tb_admin_access", array("acc_adm_code" => $id ));
    }
    return $hasil;
  }

  public function getMenuData($id){
    $sql = "SELECT acc_id, acc_adm_code, acc_access, menu_name, menu_link, acc_active, menu_sequences FROM tb_admin_access
            LEFT JOIN tb_menus ON menu_code = acc_access
            WHERE acc_adm_code = '$id' AND menu_parent != '0' ORDER BY menu_sequences ";
    return $this->func->db_execute($sql);
  }

  public function saveMenuData($post){
    $acc_prt = explode(",", $post['acc_access'] )[0];
    $acc_code = explode(",", $post['acc_access'] )[1];

    $data = array(
      'acc_adm_code'  => $post['acc_adm_code'],
      'acc_access'    => $acc_code,
      'acc_active'    => $post['acc_active'],
      'created_date'  => $post['created_date'],
      'created_by'    => $post['created_by']
    );
    //$this->renderJSON($data);
    /**/
    //cek di database
    $sql = "SELECT COUNT(*) jml FROM tb_admin_access WHERE acc_adm_code = '" . $post['acc_adm_code'] . "' AND acc_access ='". $acc_code ."' ";
    $hasil = $this->func->db_execute($sql);
    if($hasil['data'][0]['jml'] > 0){
      $result = array(
        "kind" => "error",
        "status_code" => 400,
        "description" => "Already Exist !"
      );
      return $result;
    }else{
      $sql1 = "SELECT COUNT(*) jml FROM tb_admin_access WHERE acc_adm_code = '" . $post['acc_adm_code'] . "' AND acc_access ='". $acc_prt ."' ";
      $hasil1 = $this->func->db_execute($sql1);
      if($hasil1['data'][0]['jml'] < 1){
        $data1 = array(
          'acc_adm_code'  => $post['acc_adm_code'],
          'acc_access'    => $acc_prt,
          'created_date'  => $post['created_date'],
          'created_by'    => $post['created_by']
        );
        $this->func->db_insert("tb_admin_access", $data1);
      }
      return $this->func->db_insert("tb_admin_access", $data);
    }
  }

  public function getUserMenu($id){
    $sql = "SELECT acc_id, adm_code, adm_pass, adm_name, adm_level, adm_image, acc_access,
            menu_code, menu_name, menu_link, menu_icon, menu_parent, menu_sequences , acc_active
            FROM tb_admin_access
            LEFT JOIN tb_admin
            ON adm_code = acc_adm_code
            LEFT JOIN tb_menus ON acc_access = menu_code
            WHERE adm_code = '$id' AND menu_parent = '0' ORDER BY menu_sequences ";
    $main_menu = $this->func->db_execute($sql);

    foreach ($main_menu['data'] as $main) {
      // Query untuk mencari data sub menu
      $sql = "SELECT * FROM tb_menus
      LEFT JOIN tb_admin_access ON acc_access = menu_code
      WHERE acc_adm_code = '$id' AND menu_parent = '" . $main['menu_code'] . "'";
      $sub_menu = $this->func->db_execute($sql);

      // periksa apakah ada sub menu
      if (count($sub_menu['data']) > 0) {
        // main menu dengan sub menu
        echo "<li class='demo_menus menu_" . $main['menu_code'] . "'><a><i class='" . $main['menu_icon'] . "'></i>&nbsp;&nbsp;<span>" . $main['menu_name'] .
        "</span><span class=''>
        </span></a>";
        // sub menu nya disini
        echo "<ul class='demo_sub_menus'>";
        foreach ($sub_menu['data'] as $sub) {
          //if($sub['menu_code'] == $main['acc_access'] ){
          echo "<li class='menu_" . $sub['menu_code'] . "'><a><i class='" . $sub['menu_icon'] . "'></i>&nbsp;&nbsp;<span>" . $sub['menu_name'] ."</span></a></li>";            
          //}
        }
        echo"</ul></li>";
      } else {
        // main menu tanpa sub menu
        echo "<li class='demo_menus'><a><i class='" . $main['menu_icon'] . "'></i>&nbsp;&nbsp;<span>" . $main['menu_name'] ."</span></a></li>";
      }
    }
  }


  public function deleteMenu($id){
    return $this->func->db_delete("tb_admin_access", array("acc_id" => $id ));
  }


}

?>