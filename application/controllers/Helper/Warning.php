<?php

require_once('Base.php');

class Warning {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function getHeaderWrn($kecamatan, $project){
    $param = ""; $param2 = "";
    if($kecamatan != "all"){
      $param = "WHERE wl_kec = '$kecamatan'";
    }

    if($param == ""){
      if($project != "all"){
        $param2 = " WHERE wl_project = '$project'";
      }      
    }else{
      if($project != "all"){
        $param2 = " AND wl_project = '$project'";
      }            
    }

    $sql = "SELECT * FROM tb_warning_h $param $param2";
    return $this->func->db_execute($sql);
  }

  public function getWarningIp($ip){
    $sql = "SELECT wrn_ip, wrn_pole, wrn_loc_lat, wrn_loc_lon, wrn_loc_desc, wrn_duration, wrn_status 
            FROM tb_warning WHERE wrn_ip = '12345' ";
    return $this->func->db_execute($sql);
  }

  public function get(){
    $sql = "SELECT * FROM tb_warning_h GROUP BY wl_sn";
    return $this->func->db_execute($sql);
  }

  public function getId($id){
    return $this->func->select_where("tb_warning_h", null, array("wl_sn" => $id ) );
  }

  public function getProject(){
    return $this->func->select_where("tb_project_wl", null, array("proj_active" => "Y" ) );
  }

  public function save($post){
    return $this->func->db_insert("tb_warning_h", $post);
  }

  public function update($post){
    return $this->func->db_update("tb_warning_h", $post, array('wl_sn' => $post['wl_sn'] ) );
  }

  public function saveDetail($post){
    return $this->func->db_insert("tb_warning_d", $post);
  }

  public function updateDetail($post){
    return $this->func->db_update("tb_warning_d", $post, array('wl_id' => $post['wl_id'] ) );
  }

  public function deleteDetail($id){
    return $this->func->db_delete("tb_warning_d", array("wl_id" => $id ));
  }

  public function getDetailBySn($id){
    $sql = "SELECT * FROM tb_warning_d LEFT JOIN tb_warning_h ON wl_sn = wl_sn_d WHERE wl_sn = '$id' ";
    return $this->func->db_execute($sql);
  }

  public function getDetailById($id){
    return $this->func->select_where("tb_warning_d", null, array("wl_sn_d" => $id ) );
  }

  public function getDatum($id){
    $today = date("Y-m-d");
    $date1 = date_create($today);

    $sql = "SELECT * FROM tb_warning_h LEFT JOIN tb_project_wl ON wl_project = proj_id WHERE wl_sn = '$id' ";
    $main = $this->func->db_execute($sql);
    $main['data'][0]['umur_alat'] = "";
   
    if(count($main['data']) > 0){
      $date2 = date_create($main['data'][0]['wl_install_date']);
      $main['data'][0]['umur_alat'] = number_format(date_diff($date2,$date1)->format("%a")) . " Hari - " . date_diff($date2,$date1)->format("(%y Tahun %m Bulan %d Hari) ");
    }
    return $main;
  }

  public function getStatusAlat($sn){
    $sql = "SELECT * FROM tb_rpt_warning WHERE wl_sn = '$sn' LIMIT 24";
    return $this->func->db_execute($sql);
  }

    //WARNING
  public function inputWrn(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT * FROM inbox WHERE `data` LIKE '%WL%' LIMIT 1000 ";
    $main = $this->func->db_execute($sql);

    if(count($main['data']) > 0){
      $id_array = array();
      $result = array();
      foreach ($main['data'] as $key => $value) {
        $pars = explode("|", $value['data']);
        if(count($pars) > 10){
          if($pars[1] == "WL"){
            array_push($id_array, $value['id_inbox']);
            array_push($result, 
              array(
                "wl_rpt_date"     => $value['date'],
                "wl_pole"         => $pars[2],
                "wl_password"     => $pars[3],
                "wl_sn"           => $pars[4],
                "wl_waktu"        => $pars[5],
                "wl_teg_batt"     => $pars[6],
                "wl_teg_sollar"   => $pars[7],
                "wl_percent_batt" => $pars[8],
                "wl_arus"         => $pars[9],
                "wl_suhu"         => $pars[10],
                "wl_mode_flash"   => $pars[11],
                "wl_data_flashing"=> $pars[12],
                "wl_status"       => $pars[13]
              )
            );
          }
        }
      }

      $in = "('" . implode("','", $id_array) . "')";
      $insert = $this->func->db_insert("tb_rpt_warning", $result);
      if($insert['code']=="200"){
        //insert into inbox_archieve
        $archieve = $this->func->db_execute("SELECT `date`, data FROM inbox WHERE id_inbox IN $in ");
        if(count($archieve['data']) > 0){
          foreach ($archieve['data'] as $key => $value) {
            $archieve['data'][$key]['last_sync'] = date('Y-m-d H:i:s');
          }
          $arch = $this->func->db_insert("inbox_archieve_wrn", $archieve['data'] );
          if($arch['code']=="200"){
            $this->func->db_delete("inbox", array("id_inbox" => $id_array));
          }else{
            $logss = array(
              "log_data"      => $arch['message'],
              "log_data_date" => "error gaes",
              "log_exe_date"  => date('Y-m-d'),
              "log_exe_time"  => date('H:i:s')
            );
            $insert_logs = $this->func->db_insert("log_ews_parsing", $logss);
          }
        }
        $resp = array(
          "kind" => "success",
          "status_code" => "200",
          "description" => count($result) . " data(s) inserted",
          "data" => array()
        );
      }else{
        $resp = array(
          "kind" => "error",
          "status_code" => "400",
          "description" => $this->mdb->lasterror,
          "data" => array()
        );
      }
      return $resp;
    }else{
      $resp = array(
        "kind" => "nope",
        "status_code" => "201",
        "description" => "sudah tidak ada data",
        "data" => array()
      );
      return $resp;
    }

  }

  public function getWrnByArea($prov, $city, $dist){
    $today = date('Y-m-d');
    $date1 = date_create($today);

    if($prov == 'all' && $city = 'all' && $dist == 'all'){
      $param = " ";
    }elseif($prov != 'all' && $city == 'all' && $dist == 'all'){
      $param = "WHERE wl_prov = '$prov'";
    }elseif($prov != 'all' && $city != 'all' && $dist == 'all'){
      $param = "WHERE wl_kab = '$city'";
    }elseif($prov != 'all' && $city != 'all' && $dist != 'all'){
      $param = "WHERE wl_kec = '$dist'";
    }else{
      $param = "";
    }

    $query = $this->func->db_execute("SELECT *, wl_area lokasi, tb_warning_h.wl_sn, wl_ip, 
                                DATE_FORMAT(wl_rpt_date, '%Y-%m-%d') date_rpt, DATE_FORMAT(wl_rpt_date, '%H:%i:%s') jam_rpt,
                                wl_install_date, DATEDIFF('$today', wl_install_date) install_age,
                                wl_maintenance_date, DATEDIFF('$today', wl_maintenance_date) maintenance_age
                                FROM tb_warning_h
                                LEFT JOIN v_last_wl_rpt ON v_last_wl_rpt.wl_sn = tb_warning_h.wl_sn 
                                LEFT JOIN tb_project_wl ON wl_project = proj_id 
                                LEFT JOIN tb_province ON wl_prov = prov_code
                                $param GROUP BY tb_warning_h.wl_sn ");

    return $query;
  }

}

?>