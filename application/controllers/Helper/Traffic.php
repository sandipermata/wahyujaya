<?php

require_once('Base.php');

class Traffic {

  private $func, $pdf;
  function __construct(){
    $this->func = new Base();
  }

  public function getHeaderTraffic($kecamatan){
    $param = "";
    if($kecamatan == "all"){
      $param = "";
    }else{
      $param = "WHERE tfc_kec = '$kecamatan'";
    }

    $sql = "SELECT tfc_sn, tfc_ip, a.tfc_loc_lat, a.tfc_loc_lon, tfc_jalan, tfc_kec,
            a.tfc_status, a.tfc_device_sts, icon_name, icon_image 
            FROM tb_traffic_h a
            LEFT JOIN tb_icons b ON b.icon_id = a.tfc_device_sts $param";
    return $this->func->db_execute($sql);
  }

  public function getTrafficIp($ip){
    $sql = "SELECT tfc_sn_d tfc_sn, tfc_pole, tfc_loc_lat, tfc_loc_lon, tfc_loc_desc, 
				    IF(tfc_G1 > 0, tfc_G1, tfc_G) tfc_duration, tfc_G, tfc_status, tfc_g_image, tfc_r_image,
				    (SELECT tfc_flash_image FROM tb_traffic_h WHERE tfc_sn = tfc_sn_d ) img_flash,
				    (SELECT tfc_loc_image FROM tb_traffic_h WHERE tfc_sn = tfc_sn_d ) img_location
				    FROM tb_traffic_d  WHERE tfc_sn_d = '$ip'";
    return $this->func->db_execute($sql);
  }

  public function get(){
    $sql = "SELECT * FROM tb_traffic_h GROUP BY tfc_sn";
    return $this->func->db_execute($sql);
  }

  public function getId($id){
    return $this->func->select_where("tb_traffic_h", null, array("tfc_sn" => $id ) );
  }

  public function save($post){
    return $this->func->db_insert("tb_traffic_h", $post);
  }

  public function update($post){
    return $this->func->db_update("tb_traffic_h", $post, array("AND" => array('tfc_sn' => $this->post['tfc_sn'] )) );
  }

  public function delete($id){
    return $this->func->db_delete("tb_traffic_d", array("tfc_id" => $id ));
  }

  public function saveUpload($post){
    $jml = 0;
    foreach ($post[0]['header'] as $key => $value) {
      $check = $this->func->db_execute("SELECT * FROM tb_traffic_h WHERE tfc_sn = '" . $value['tfc_sn'] ."'");
      if(count($check['data']) < 1 ){
        $insert = $this->func->db_insert("tb_traffic_h", $post[0]['header'][$key]);
        if($insert['code'] == "200"){
          $jml++;
          $resultH = array( "ACK"=>"OK","msg"=>"berhasil");
        }else{
          $resultH = array("ACK"=>"NOK","msg"=>$insert['message']);        
        }
      }else{
        $resultH = array("ACK"=>"NOK","msg"=>"data sudah ada");        
      }
    }

    //input detail
    $jmld = 0;
    foreach ($post[0]['detail'] as $k => $v) {
      $chk = $this->func->db_execute("SELECT * FROM tb_traffic_d WHERE tfc_sn_d = '" . $v['tfc_sn_d'] ."' AND tfc_pole = '" . $v['tfc_pole'] ."'");
      if(count($chk['data']) < 1 ){
        $ins = $this->func->db_insert("tb_traffic_d", $post[0]['detail'][$k]);
        if($ins['code'] == "200" ){
          $jmld++;
          $resultD = array("ACK"=>"OK","msg"=>"berhasil");
        }else{
          $resultD = array("ACK"=>"NOK","msg"=>$ins['message']);
        }
      }else{
        $resultD = array("ACK"=>"NOK","msg"=>"data sudah ada");          
      }
    }
    $result = array(
      "kind" => "success",
      "status_code" => 200,
      "description" => "OK",
      "data" => array(
        "data_header" => array(
          "inserted" => $jml,
          "data" => array($resultH)
        ),
        "data_detail" => array(
          "inserted" => $jmld,
          "data" => array($resultD)
        ),
      )
    );

    return $result;
  }

  public function reset($post){
    $this->func->db_update("tb_traffic_d", array("tfc_status" => "mati", "tfc_G1" => "0"), array('tfc_sn_d' => $post['tfc_sn_d']) );
    return $this->func->db_update("tb_traffic_d", $post, array("AND" => array('tfc_sn_d' => $post['tfc_sn_d'], 'tfc_pole' => $post['tfc_pole'] )) );
  }


  public function getDetail($id){
    return $this->func->db_execute("SELECT * FROM tb_traffic_d LEFT JOIN tb_icons ON tfc_device_sts = icon_id WHERE tfc_sn_d = '$id'");
  }

  public function saveDetail($post){
    return $this->func->db_insert("tb_traffic_d", $post);
  }

  public function updateDetail($post){
    return $this->func->db_update("tb_traffic_d", $post, array("AND" => array('tfc_id' => $post['tfc_id'] )) );
  }

  public function getDatum($id){
    $today = date("Y-m-d");
    $date1 = date_create($today);

    $sql = "SELECT * FROM tb_traffic_h WHERE tfc_sn = '$id' ";
    $main = $this->func->db_execute($sql);
    $main['data'][0]['rambu_icon'] = array();
    $main['data'][0]['umur_alat'] = "";
   
    $str = $main['data'][0]['tfc_rambu'];
    $str2 = explode(",", str_replace("\"", "", str_replace("]", "", str_replace("[", "", $str)))   );
    if(count($main['data']) > 0){
      $date2 = date_create($main['data'][0]['tfc_install_date']);
      $main['data'][0]['umur_alat'] = number_format(date_diff($date2,$date1)->format("%a")) . " Hari - " . date_diff($date2,$date1)->format("(%y Tahun %m Bulan %d Hari) ");
      for ($i=0; $i < count( $str2 ) ; $i++) { 
        $child = $this->func->select_where("tb_rambu", null, array("rambu_id" => $str2[$i] ) );
        if(count($child['data']) > 0){
          array_push($main['data'][0]['rambu_icon'], $child['data'][0]['rambu_image'] );
        }
      }
    }
    return $main;
  }

  public function getHistory($ip){
    return $this->func->select_where("tb_detail_maintenance", null, array("AND" => array("mnt_sn_code" => $ip, "mnt_category" => 'tfc' ) ) );
  }

  public function saveHistory($post){
    $insert = $this->func->db_insert("tb_detail_maintenance", $post);
    if($insert['code'] == "200" ){
      $this->func->db_update("tb_traffic_h", array('tfc_maintenance_date' => $post['mnt_year'] ), array('tfc_sn' => $post['mnt_sn_code'] ));
    }
    return $insert;
  }

  public function updateHistory($post, $code){
    $update = $this->func->db_update("tb_detail_maintenance", $post, array("mnt_id" => $code));
    if($update['code'] == "200" ){
      $this->func->db_update("tb_traffic_h", array('tfc_maintenance_date' => $post['mnt_year'] ), array('tfc_sn' => $post['mnt_sn_code'] ));
    }
    return $update;
  }

  public function deleteHistory($id){
    return $this->func->db_delete("tb_detail_maintenance", array("mnt_id" => $id ));
  }


  public function inputTfc(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT * FROM inbox WHERE `data` LIKE '%TRAFFIC%' LIMIT 1000 ";
    $main = $this->func->db_execute($sql);
    if(count($main['data']) > 0){
      $id_array = array();
      $result = array();
      foreach ($main['data'] as $key => $value) {
        $pars = explode("|", $value['data']);
        if(count($pars) >= 18){
          if($pars[1] == "TRAFFIC"){
            array_push($id_array, $value['id_inbox']);
            array_push($result, 
              array(
                "tl_rpt_date"       => $value['date'],
                "tl_sn"             => $pars[2],
                "tl_password"       => $pars[3],
                "tl_ip"             => $pars[4],
                "tl_sinyal_wifi"    => $pars[5],
                "tl_jam_controller" => $pars[6],
                "tl_kode_pola"      => $pars[7],
                "tl_1_RYG"          => $pars[8],
                "tl_2_RYG"          => $pars[9],
                "tl_3_RYG"          => $pars[10],
                "tl_4_RYG"          => $pars[11],
                "tl_timer_pendek"   => $pars[12],
                "tl_timer_panjang"  => $pars[13],
                "tl_timer_flash"    => $pars[14],
                "tl_arus_ac"        => $pars[15],
                "tl_suhu_panel"     => $pars[16],
                "tl_life_cycle"     => $pars[17],
                "tl_kode_unik"      => $pars[18],
                "tl_teg_ac"         => $pars[19],
                "tl_daya"           => $pars[20],
                "tl_lembab"         => $pars[21],
                "tl_teg_bat_back"   => $pars[22],
              )
            );
          }
        }
      }

      $in = "('" . implode("','", $id_array) . "')";
      $insert = $this->func->db_insert("tb_rpt_traffic", $result);
      if($insert['code'] == "200" ){
        //insert into inbox_archieve
        $archieve = $this->func->db_execute("SELECT `date`, data FROM inbox WHERE id_inbox IN $in ");
        if(count($archieve['data']) > 0){
          foreach ($archieve['data'] as $key => $value) {
            $archieve['data'][$key]['last_sync'] = date('Y-m-d H:i:s');
          }
          $arch = $this->func->db_insert("inbox_archieve_tfc", $archieve['data'] );
          if($arch['code'] =="200"){
            $this->func->db_delete("inbox", array("id_inbox" => $id_array));            
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
          "description" => $insert['message'],
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

  public function getTfcByArea($prov, $city, $dist){
    $today = date('Y-m-d');
    $date1 = date_create($today);

    if($prov == 'all' && $city = 'all' && $dist == 'all'){
      $param = " ";
    }elseif($prov != 'all' && $city == 'all' && $dist == 'all'){
      $param = "WHERE tfc_prov = '$prov'";
    }elseif($prov != 'all' && $city != 'all' && $dist == 'all'){
      $param = "WHERE tfc_kab = '$city'";
    }elseif($prov != 'all' && $city != 'all' && $dist != 'all'){
      $param = "WHERE tfc_kec = '$dist'";
    }else{
      $param = "";
    }
    return $this->func->db_execute("SELECT *, tfc_area lokasi, tfc_sn, tfc_ip, 
                                DATE_FORMAT(tl_rpt_date, '%Y-%m-%d') date_rpt, DATE_FORMAT(tl_rpt_date, '%H:%i:%s') jam_rpt,
                                tfc_install_date, DATEDIFF('$today', tfc_install_date) install_age,
                                tfc_maintenance_date, DATEDIFF('$today', tfc_maintenance_date) maintenance_age
                                FROM tb_traffic_h
                                LEFT JOIN v_last_tfc_rpt ON tl_sn = tfc_sn 
                                LEFT JOIN tb_project ON tfc_project = project_code 
                                LEFT JOIN tb_province ON tfc_prov = prov_code
                                $param GROUP BY tfc_sn ");

  }

  public function getTfcBySn($sn, $from, $to){
    $today = date('Y-m-d');
    $sensor = ['tidak-ada-arus-listrik.gif','ada-arus-listrik.png'];
    $params = "";
    $limit = " LIMIT 24";
    if($from != "all"){
      $params = " AND DATE_FORMAT(tl_rpt_date,'%Y-%m-%d') BETWEEN '$from' AND '$to' "; 
      $limit = "";
    }
 
    $query = $this->func->db_execute("SELECT 
                                tfc_ip, tfc_sn, tfc_jalan, tfc_area, tfc_cross_type, tl_kode_pola,
                                tl_1_RYG, tl_2_RYG, tl_3_RYG, tl_4_RYG,
                                tfc_install_date, DATEDIFF(CURDATE(), tfc_install_date) install_age,
                                tfc_maintenance_date, DATEDIFF(CURDATE(), tfc_maintenance_date) maintenance_age,
                                DATE_FORMAT(tl_rpt_date, '%Y-%m-%d') date_rpt, DATE_FORMAT(tl_rpt_date, '%H:%i:%s') jam_rpt,
                                tfc_cross_type, tl_1_RYG, tl_2_RYG, tl_3_RYG, tl_4_RYG, tl_timer_panjang, tl_timer_pendek, tl_timer_flash,
                                tl_arus_ac, tl_suhu_panel, tl_sinyal_wifi, tl_life_cycle, tl_teg_ac, tl_daya, tl_lembab
                                FROM tb_rpt_traffic
                                LEFT JOIN tb_traffic_h ON tl_sn = tfc_sn
                                WHERE tfc_sn = '$sn' $params ORDER BY tl_rpt_date DESC $limit");

    if(count($query['data']) > 0){
      $dtl = $this->func->db_execute("SELECT tfc_pole, tfc_loc_lat, tfc_loc_lon, tfc_G, tfc_G1, tfc_R, tfc_loc_desc 
                                      FROM tb_traffic_d WHERE tfc_sn_d = '" . $query['data'][0]['tfc_sn'] . "' ");
      foreach ($query['data'] as $key => $value) {
        $query['data'][$key]['detail'] = $dtl['data'];

        if($value['tl_arus_ac'] == "0" ){
          $query['data'][$key]['icon_listrik'] = $sensor[0];
        }else{
          $query['data'][$key]['icon_listrik'] = $sensor[1];          
        }
      }      
    }
    return $query;
  }

  public function getTfcAvailable(){
    $today = date('Y-m-d');
    $sql = "SELECT tfc_sn, CONCAT(tfc_jalan, ' - ' , tfc_area) lokasi, tfc_ip, 
            tfc_install_date, DATEDIFF('$today', tfc_install_date) install_age,
            tfc_maintenance_date, DATEDIFF('$today', tfc_maintenance_date) maintenance_age
            FROM tb_traffic GROUP BY tfc_sn ";
    return $this->func->db_execute($sql);
  }

  public function getReportTfc($ip, $date){
    $sql = "SELECT *, DATE_FORMAT(tl_rpt_date, '%H:%i:%s') jam_rpt FROM tb_rpt_traffic 
            WHERE tl_ip = '$ip' AND DATE_FORMAT(tl_rpt_date, '%Y-%m-%d') = '$date' ORDER BY tl_rpt_date DESC ";
    return $this->func->db_execute($sql);
  }



}

?>