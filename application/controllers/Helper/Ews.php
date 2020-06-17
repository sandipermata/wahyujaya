<?php

require_once('Base.php');

class Ews {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function getHeaderEws($kecamatan){
    $param = "";
    if($kecamatan == "all"){
      $param = "";
    }else{
      $param = "WHERE ews_kec = '$kecamatan'";
    }

    // $sql = "SELECT ews_ip, ews_id, ews_pole, ews_loc_lat, ews_loc_lon, ews_loc_desc, ews_duration, ews_status, icon_name, icon_image, ews_arah, ews_rpt_date,
    //         DATEDIFF(CURDATE(),ews_rpt_date) lama
    //         FROM tb_ews 
    //         LEFT JOIN tb_icons ON icon_id = ews_status
    //         LEFT JOIN v_last_ews_rpt ON ews_sn = ews_ip $param ";
    $sql = "SELECT ews_id, ews_ip, ews_loc_lat, ews_loc_lon, ews_area,
            (SELECT COUNT(*) FROM v_last_ews_rpt WHERE ews_sn = ews_ip ) jml
            FROM tb_ews $param";
    $head = $this->func->db_execute($sql);
    foreach ($head['data'] as $key => $value) {
      $head['data'][$key]['rpt'] = array();
      if($value['jml'] != "0"){
        $rpt = $this->func->db_execute("SELECT ews_battery_percent, ews_arah, ews_status_sensor_L, ews_status_sensor_C, ews_status_sensor_R, ews_suhu_confan, ews_teg_out_sirine, ews_sirine_mute, ews_arus_lam_stop, ews_arus_lam_flash, ews_arus_lam_left, ews_arus_lam_right, ews_arus_speaker 
          FROM v_last_ews_rpt WHERE ews_sn = '" . $value['ews_ip'] . "' ");

        foreach ($rpt['data'] as $k => $val) {
          //lampu merah
          if( floatval($val['ews_arus_lam_stop']) >= 0.10 && $val['ews_arah'] != "NONE" ){
            $rpt['data'][$k]['lampu_merah'] = "ON";
          }elseif (floatval($val['ews_arus_lam_stop']) < 0.10 && $val['ews_arah'] != "NONE") {
            $rpt['data'][$k]['lampu_merah'] = "RUSAK";
          }elseif (floatval($val['ews_arus_lam_stop']) < 0.10 && $val['ews_arah'] == "NONE") {
            $rpt['data'][$k]['lampu_merah'] = "OFF";
          }

          //lampu kuning
          if( floatval($val['ews_arus_lam_flash']) >= 0.10 && $val['ews_arah'] == "NONE" ){
            $rpt['data'][$k]['lampu_kuning'] = "ON";
          }elseif (floatval($val['ews_arus_lam_flash']) < 0.10 && $val['ews_arah'] == "NONE") {
            $rpt['data'][$k]['lampu_kuning'] = "RUSAK";
          }elseif (floatval($val['ews_arus_lam_flash']) < 0.10 && $val['ews_arah'] != "NONE") {
            $rpt['data'][$k]['lampu_kuning'] = "OFF";
          }

          // $arah    = ['arah_kanan.gif','arah_kiri.gif','arah-none.png','arah_kanan_rusak.png','arah_kiri_rusak.png'];

          if($val['ews_arah'] == 'LEFT'){
            $rpt['data'][$k]['arah_icon'] = "kiri";
          }elseif($val['ews_arah'] == 'RIGHT'){
            $rpt['data'][$k]['arah_icon'] = "kanan";
          }else{
            $rpt['data'][$k]['arah_icon'] = "none";
          }

          //lampu arah
          //ews_arus_lam_left, ews_arus_lam_right
          if( floatval($val['ews_arus_lam_left']) < 0.10 && $val['ews_arah'] == "LEFT" ){
            $rpt['data'][$k]['lampu_arah'] = "rusak";
          }elseif (floatval($val['ews_arus_lam_right']) < 0.10 && $val['ews_arah'] == "RIGHT") {
            $rpt['data'][$k]['lampu_arah'] = "rusak";
          }elseif (floatval($val['ews_arus_lam_left']) >= 0.10 && $val['ews_arah'] == "LEFT") {
            $rpt['data'][$k]['lampu_arah'] = "kiri_ok";
          }elseif (floatval($val['ews_arus_lam_right']) >= 0.10 && $val['ews_arah'] == "RIGHT") {
            $rpt['data'][$k]['lampu_arah'] = "kanan_ok";
          }elseif (floatval($val['ews_arus_lam_flash']) < 0.10 && $val['ews_arah'] == "NONE") {
            $rpt['data'][$k]['lampu_arah'] = "none";
          }elseif (floatval($val['ews_arus_lam_flash']) >= 0.10 && $val['ews_arah'] == "NONE") {
            $rpt['data'][$k]['lampu_arah'] = "none";
          }

           // Mark : - Speaker
          if( floatval($val['ews_arus_speaker']) >= 0.10 && floatval($val['ews_teg_out_sirine']) >= 0.10 && floatval($val['ews_sirine_mute']) == 1 && $val['ews_arah'] != "NONE" ){
            $query['data'][$k]['speaker'] = "ON";
          }elseif (floatval($val['ews_arus_speaker']) < 0.10 && floatval($val['ews_teg_out_sirine']) < 0.10 && floatval($val['ews_sirine_mute']) == 1 && $val['ews_arah'] == "NONE") {
            $query['data'][$k]['speaker'] = "OFF";
          }elseif (floatval($val['ews_arus_speaker']) < 0.10 && floatval($val['ews_teg_out_sirine']) < 0.10 && floatval($val['ews_sirine_mute']) == 1  && $val['ews_arah'] != "NONE") {
            $query['data'][$k]['speaker'] = "RUSAK";
          }elseif (floatval($val['ews_arus_speaker']) < 0.10 && floatval($val['ews_teg_out_sirine']) < 0.10 && floatval($val['ews_sirine_mute']) == 0  && $val['ews_arah'] != "NONE") {
            $query['data'][$k]['speaker'] = "MUTE";
          }

        }


        $head['data'][$key]['rpt'] = $rpt['data'];

      }

    }


    return $head;
  }

  public function getEwsIp($ip){
    $sql = "SELECT ews_ip, ews_pole, ews_loc_lat, ews_loc_lon, ews_loc_desc, ews_duration, ews_status 
            FROM tb_ews WHERE ews_ip = '$ip'";
    return $this->func->db_execute($sql);
  }

  public function get(){
    $sql = "SELECT * FROM tb_ews LEFT JOIN tb_icons ON icon_id = ews_status";
    return $this->func->db_execute($sql);
  }

  public function getId($id){
    return $this->func->select_where("tb_ews", null, array("ews_id" => $id ) );
  }

  public function save($post){
    return $this->func->db_insert("tb_ews", $post);
  }

  public function update($post){
    return $this->func->db_update("tb_ews", $post, array('ews_id' => $post['ews_id'] ));
  }

  public function delete($id){
    return $this->func->db_delete("tb_ews", array("ews_id" => $id ));
  }

  public function getHistory($ip){
    return $this->func->select_where("tb_detail_maintenance", null, array("AND" => array("mnt_sn_code" => $ip, "mnt_category" => "ews" ) )  );
  }

  public function saveHistory($post){
    $insert = $this->func->db_insert("tb_detail_maintenance", $post);
    if($insert['code'] == "200" ){
      $this->func->db_update("tb_ews", array('ews_maintenance_year' => $post['mnt_year'] ), array('ews_ip' => $post['mnt_sn_code'] ));
    }
    return $insert;
  }

  public function updateHistory($post, $code){
    $update = $this->func->db_update("tb_detail_maintenance", $post, array("mnt_id" => $code));
    if($update['code'] == "200" ){
      $this->func->db_update("tb_ews", array('ews_maintenance_year' => $post['mnt_year'] ), array('ews_ip' => $post['mnt_sn_code'] ));
    }
    return $update;
  }

  public function deleteHistory($id){
    return $this->func->db_delete("tb_detail_maintenance", array("mnt_id" => $id ));
  }

  public function saveUpload($post){
    $jml = 0;
    foreach ($post as $key => $value) {
      $check = $this->func->db_execute("SELECT * FROM tb_ews WHERE ews_ip = '" . $value['ews_ip'] ."'");
      if(count($check['data']) < 1 ){
        $insert = $this->func->db_insert("tb_ews", $post[$key]);
        if($insert['code']=="200"){
          $jml++;
          $resultH = array("ACK"=>"OK","msg"=>"berhasil");
        }else{
          $resultH = array("ACK"=>"NOK","msg"=>$insert['message']);        
        }
      }else{
        $resultH = array("ACK"=>"NOK","msg"=>"data sudah ada");        
      }
    }
    $result = array(
      "kind" => "success",
      "status_code" => 200,
      "description" => "OK",
      "data" => array(
          "inserted" => $jml,
          "data" => array($resultH)
      )
    );
    return $result;
  }


  //INPUT
  public function inputEws(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT * FROM inbox WHERE `data` LIKE '%EWS%' LIMIT 1000 ";
    $main = $this->func->db_execute($sql);

    if(count($main['data']) > 0){
      $id_array = array();
      $result = array();
      $logs = array();
      foreach ($main['data'] as $key => $value) {
        $pars = explode("|", $value['data']);
        if($pars[1] == "EWS"){
          array_push($id_array, $value['id_inbox']);
          array_push($result, 
            array(
              "ews_rpt_date" => $value['date'],
              "ews_sn" => $pars[2] == "" ? "190429003" : $pars[2],
              "ews_code" => $pars[3],
              "ews_kota" => $pars[4],
              "ews_teg_pv" => $pars[5],
              "ews_teg_battery" => $pars[6],
              "ews_battery_percent" => $pars[7],
              "ews_pv_percent" => $pars[8],
              "ews_arus_pv_mppt" => $pars[9],
              "ews_arus_bat_mppt" => $pars[10],
              "ews_arus_bat" => $pars[11],
              "ews_en_charge" => $pars[12],
              "ews_chg_ind" => $pars[13],
              "ews_by_pass" => $pars[14],
              "ews_arus_lam_stop" => $pars[15],
              "ews_arus_lam_flash" => $pars[16],
              "ews_arus_lam_left" => $pars[17],
              "ews_arus_lam_right" => $pars[18],
              "ews_sirine_level" => $pars[19],
              "ews_sirine_mute" => $pars[20],
              "ews_jml_pulse_sensor_L" => $pars[21],
              "ews_jml_pulse_sensor_C" => $pars[22],
              "ews_jml_pulse_sensor_R" => $pars[23],
              "ews_status_sensor_L" => $pars[24],
              "ews_status_sensor_C" => $pars[25],
              "ews_status_sensor_R" => $pars[26],
              "ews_suhu_confan" => $pars[27],
              "ews_date_time" => $pars[28],
              "ews_arus_speaker" => $pars[29],
              "ews_lon" => $pars[30],
              "ews_modem_signal" => $pars[31],
              "ews_counter_reset" => $pars[32],
              "ews_batt_cycle" => $pars[33],
              "ews_status_cuaca" => $pars[34],
              "ews_data_irradiance" => $pars[35],
              "ews_arus_sirine" => $pars[36],
              "ews_teg_out_sirine" => $pars[37],
              "ews_status_toa" => $pars[38],
              "ews_arah" => $pars[39],
              "ews_status_chg_batt" => $pars[40],
              "ews_kecepatan" => $pars[41],
            )
          );
        }

        //insert log catch
        array_push($logs, array(
          "log_data"      => $value['data'],
          "log_data_date" => $value['date'],
          "log_exe_date"  => date('Y-m-d'),
          "log_exe_time"  => date('H:i:s')
        ));

      }

      $in = "('" . implode("','", $id_array) . "')";
      $insert_logs = $this->func->db_insert("log_ews_parsing", $logs);
      $insert = $this->func->db_insert("tb_rpt_ews", $result);
      if($insert['code'] == "200"){
        //insert into inbox_archieve
        $archieve = $this->func->db_execute("SELECT * FROM inbox WHERE id_inbox IN $in ");
        if(count($archieve['data']) > 0){
          foreach ($archieve['data'] as $key => $value) {
            $archieve['data'][$key]['last_sync'] = date('Y-m-d H:i:s');
          }
          $arch = $this->func->db_insert("inbox_archieve_ews", $archieve['data'] );
          if($arch['code'] == "200" ){
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


  public function getEwsByArea($prov, $city, $dist){
    $today = date('Y-m-d');
    $date1 = date_create($today);

    $battery = [
      'baterai_10.png','baterai_20.png','baterai_30.png','baterai_40.png','baterai_50.png',
      'baterai_60.png','baterai_70.png','baterai_80.png','baterai_90.png','baterai_100.png'
    ];
    $arah    = ['arah_kanan.gif','arah_kiri.gif','arah-none.png','arah_kanan_rusak.png','arah_kiri_rusak.png'];

    if($prov == 'all' && $city = 'all' && $dist == 'all'){
      $param = " ";
    }elseif($prov != 'all' && $city == 'all' && $dist == 'all'){
      $param = "WHERE ews_prov = '$prov'";
    }elseif($prov != 'all' && $city != 'all' && $dist == 'all'){
      $param = "WHERE ews_kab = '$city'";
    }elseif($prov != 'all' && $city != 'all' && $dist != 'all'){
      $param = "WHERE ews_kec = '$dist'";
    }

    //sini
    $query = $this->func->db_execute("SELECT *, REPLACE(SUBSTRING_INDEX(ews_km,'(',1),'jpl ','') ews_jpl , REPLACE(SUBSTRING_INDEX(ews_km,'( ', -1),')','') ews_kms FROM tb_ews 
                                LEFT JOIN v_last_ews_rpt ON ews_ip = ews_sn 
                                LEFT JOIN tb_project ON ews_project = project_code 
                                LEFT JOIN tb_province ON ews_prov = prov_code
                                $param GROUP BY ews_ip");

    foreach ($query['data'] as $key => $value) {
      if($value['ews_battery_percent'] <= 10){
        $query['data'][$key]['icon_bat'] = $battery[0];
      }elseif($value['ews_battery_percent'] <= 20){
        $query['data'][$key]['icon_bat'] = $battery[1];
      }elseif($value['ews_battery_percent'] <= 30){
        $query['data'][$key]['icon_bat'] = $battery[2];
      }elseif($value['ews_battery_percent'] <= 40){
        $query['data'][$key]['icon_bat'] = $battery[3];
      }elseif($value['ews_battery_percent'] <= 50){
        $query['data'][$key]['icon_bat'] = $battery[4];
      }elseif($value['ews_battery_percent'] <= 60){
        $query['data'][$key]['icon_bat'] = $battery[5];
      }elseif($value['ews_battery_percent'] <= 70){
        $query['data'][$key]['icon_bat'] = $battery[6];
      }elseif($value['ews_battery_percent'] <= 80){
        $query['data'][$key]['icon_bat'] = $battery[7];
      }elseif($value['ews_battery_percent'] <= 90){
        $query['data'][$key]['icon_bat'] = $battery[8];
      }else{
        $query['data'][$key]['icon_bat'] = $battery[9];        
      }

      if($value['ews_arah'] == 'LEFT'){
        $query['data'][$key]['arah_icon'] = $arah[1];
      }elseif($value['ews_arah'] == 'RIGHT'){
        $query['data'][$key]['arah_icon'] = $arah[0];
      }else{
        $query['data'][$key]['arah_icon'] = $arah[2];        
      }

      //lampu arah
      //ews_arus_lam_left, ews_arus_lam_right
      if( floatval($value['ews_arus_lam_left']) < 0.15 && $value['ews_arah'] == "LEFT" ){
        $query['data'][$key]['lampu_arah'] = $arah[4];
      }elseif (floatval($value['ews_arus_lam_right']) < 0.15 && $value['ews_arah'] == "RIGHT") {
        $query['data'][$key]['lampu_arah'] = $arah[3];
      }elseif (floatval($value['ews_arus_lam_left']) >= 0.15 && $value['ews_arah'] == "LEFT") {
        $query['data'][$key]['lampu_arah'] = $arah[1];
      }elseif (floatval($value['ews_arus_lam_right']) >= 0.15 && $value['ews_arah'] == "RIGHT") {
        $query['data'][$key]['lampu_arah'] = $arah[0];
      }elseif (floatval($value['ews_arus_lam_flash']) < 0.20 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_arah'] = $arah[2];
      }elseif (floatval($value['ews_arus_lam_flash']) >= 0.20 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_arah'] = $arah[2];
      }

      $date2 = date_create($query['data'][$key]['ews_install_year']);
      $query['data'][$key]['umur_alat'] = date_diff($date2,$date1)->format("%a");

      $date3 = date_create($query['data'][$key]['ews_maintenance_year']);
      $query['data'][$key]['umur_alat_rawat'] = date_diff($date3,$date1)->format("%a");

    }
    return $query;
  }

  public function getEwsAvailable(){
    $sql = "SELECT ews_kota FROM tb_rpt_ews GROUP BY ews_kota ";
    return $this->func->db_execute($sql);
  }

  public function getEwsByCity($city){
    $sql = "SELECT ews_sn, ews_id FROM tb_rpt_ews WHERE ews_kota = '$city' GROUP BY ews_kota ";
    return $this->func->db_execute($sql);
  }

  public function getEwsBySnOld($sn){
    $sql = "SELECT *, DATE_FORMAT(ews_rpt_date, '%H:%i:%s') jam_rpt FROM tb_rpt_ews WHERE ews_sn = '$sn' ORDER BY ews_rpt_date DESC ";
    return $this->func->db_execute($sql);
  }

  public function getEwsBySn($sn, $from, $to){
    $today = date('Y-m-d');

    $params = "";
    $limit = " LIMIT 24";
    if($from != "all"){
      $params = " AND DATE_FORMAT(ews_rpt_date,'%Y-%m-%d') BETWEEN '$from' AND '$to' "; 
      $limit = "";
    }

    $battery = [
      'baterai_10.png','baterai_20.png','baterai_30.png','baterai_40.png','baterai_50.png',
      'baterai_60.png','baterai_70.png','baterai_80.png','baterai_90.png','baterai_100.png'
    ];
    $sirine  = ['sirine_lev_0.gif','volume_sirine_evel_1.png','volume_sirine_evel_2.png','volume_sirine_evel_3.png','Speaker_Bunyi.gif'];
    $sensor  = ['sensor_on.gif','sensor_off.gif'];
    $chg_ind = ['solar_cel_charging.gif','solar_cel_discharging.png'];
    $arah    = ['arah_kanan.gif','arah_kiri.gif','arah-none.png','arah_kanan_rusak.png','arah_kiri_rusak.png'];

    $query = $this->func->db_execute("SELECT DATE_FORMAT(ews_rpt_date, '%Y-%m-%d') date_rpt, DATE_FORMAT(ews_rpt_date, '%H:%i:%s') jam_rpt,
                ews_battery_percent, ews_teg_battery, ews_sirine_level,
                ews_jml_pulse_sensor_R, ews_status_sensor_R, ews_jml_pulse_sensor_C,
                ews_status_sensor_C, ews_jml_pulse_sensor_L, ews_status_sensor_L, ews_arus_speaker,ews_teg_out_sirine, ews_sirine_mute,
                ews_suhu_confan, ews_modem_signal, ews_status_toa , ews_arus_pv_mppt, ews_chg_ind, ews_arah, ews_kecepatan,
                ews_dir_left, ews_dir_right, ews_arus_lam_stop, ews_arus_lam_flash, ews_arus_lam_left, ews_arus_lam_right
                FROM tb_rpt_ews 
                LEFT JOIN tb_ews ON ews_sn = ews_ip
                WHERE ews_sn = '$sn' $params GROUP BY ews_rpt_date ORDER BY ews_rpt_date DESC $limit");

    foreach ($query['data'] as $key => $value) {
      if($value['ews_battery_percent'] <= 10){
        $query['data'][$key]['icon_bat'] = $battery[0];
      }elseif($value['ews_battery_percent'] <= 20){
        $query['data'][$key]['icon_bat'] = $battery[1];
      }elseif($value['ews_battery_percent'] <= 30){
        $query['data'][$key]['icon_bat'] = $battery[2];
      }elseif($value['ews_battery_percent'] <= 40){
        $query['data'][$key]['icon_bat'] = $battery[3];
      }elseif($value['ews_battery_percent'] <= 50){
        $query['data'][$key]['icon_bat'] = $battery[4];
      }elseif($value['ews_battery_percent'] <= 60){
        $query['data'][$key]['icon_bat'] = $battery[5];
      }elseif($value['ews_battery_percent'] <= 70){
        $query['data'][$key]['icon_bat'] = $battery[6];
      }elseif($value['ews_battery_percent'] <= 80){
        $query['data'][$key]['icon_bat'] = $battery[7];
      }elseif($value['ews_battery_percent'] <= 90){
        $query['data'][$key]['icon_bat'] = $battery[8];
      }else{
        $query['data'][$key]['icon_bat'] = $battery[9];        
      }

      if($value['ews_sirine_level'] == '0'){
        $query['data'][$key]['icon_sirine'] = $sirine[0];
      }elseif($value['ews_sirine_level'] == '1'){
        $query['data'][$key]['icon_sirine'] = $sirine[1];
      }elseif($value['ews_sirine_level'] == '2'){
        $query['data'][$key]['icon_sirine'] = $sirine[2];
      }else{
        $query['data'][$key]['icon_sirine'] = $sirine[3];        
      }

      if($value['ews_jml_pulse_sensor_R'] <= 2){
        $query['data'][$key]['icon_sensor_R'] = $sensor[1];
      }else{
        $query['data'][$key]['icon_sensor_R'] = $sensor[0];
      }

      if($value['ews_jml_pulse_sensor_C'] <= 2){
        $query['data'][$key]['icon_sensor_C'] = $sensor[1];
      }else{
        $query['data'][$key]['icon_sensor_C'] = $sensor[0];
      }

      if($value['ews_jml_pulse_sensor_L'] <= 2){
        $query['data'][$key]['icon_sensor_L'] = $sensor[1];
      }else{
        $query['data'][$key]['icon_sensor_L'] = $sensor[0];
      }

      $query['data'][$key]['icon_suhu'] = 'suhu_box_panel.png';

      if($value['ews_status_toa'] == '0' || $value['ews_status_toa'] == ''){
        $query['data'][$key]['icon_status_toa'] = $sirine[0];
      }else{
        $query['data'][$key]['icon_status_toa'] = $sirine[4];
      }

      if($value['ews_chg_ind'] == 'ON'){
        $query['data'][$key]['icon_chg_ind'] = $chg_ind[0];
        $query['data'][$key]['chg_ind_status'] = "charging";
      }else{
        $query['data'][$key]['icon_chg_ind'] = $chg_ind[1];
        $query['data'][$key]['chg_ind_status'] = "discharging";
      }

      //lampu merah
      if( floatval($value['ews_arus_lam_stop']) >= 0.10 && $value['ews_arah'] != "NONE" ){
        $query['data'][$key]['lampu_merah'] = "ON";
      }elseif (floatval($value['ews_arus_lam_stop']) < 0.10 && $value['ews_arah'] != "NONE") {
        $query['data'][$key]['lampu_merah'] = "RUSAK";
      }elseif (floatval($value['ews_arus_lam_stop']) < 0.10 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_merah'] = "OFF";
      }

      //lampu kuning
      if( floatval($value['ews_arus_lam_flash']) >= 0.10 && $value['ews_arah'] == "NONE" ){
        $query['data'][$key]['lampu_kuning'] = "ON";
      }elseif (floatval($value['ews_arus_lam_flash']) < 0.10 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_kuning'] = "RUSAK";
      }elseif (floatval($value['ews_arus_lam_flash']) < 0.10 && $value['ews_arah'] != "NONE") {
        $query['data'][$key]['lampu_kuning'] = "OFF";
      }

      // $arah    = ['arah_kanan.gif','arah_kiri.gif','arah-none.png','arah_kanan_rusak.png','arah_kiri_rusak.png'];

      if($value['ews_arah'] == 'LEFT'){
        $query['data'][$key]['arah_icon'] = $arah[1];
      }elseif($value['ews_arah'] == 'RIGHT'){
        $query['data'][$key]['arah_icon'] = $arah[0];
      }else{
        $query['data'][$key]['arah_icon'] = $arah[2];
      }

      //lampu arah
      //ews_arus_lam_left, ews_arus_lam_right
      if( floatval($value['ews_arus_lam_left']) < 0.10 && $value['ews_arah'] == "LEFT" ){
        $query['data'][$key]['lampu_arah'] = $arah[4];
      }elseif (floatval($value['ews_arus_lam_right']) < 0.10 && $value['ews_arah'] == "RIGHT") {
        $query['data'][$key]['lampu_arah'] = $arah[3];
      }elseif (floatval($value['ews_arus_lam_left']) >= 0.10 && $value['ews_arah'] == "LEFT") {
        $query['data'][$key]['lampu_arah'] = $arah[1];
      }elseif (floatval($value['ews_arus_lam_right']) >= 0.10 && $value['ews_arah'] == "RIGHT") {
        $query['data'][$key]['lampu_arah'] = $arah[0];
      }elseif (floatval($value['ews_arus_lam_flash']) < 0.10 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_arah'] = $arah[2];
      }elseif (floatval($value['ews_arus_lam_flash']) >= 0.10 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['lampu_arah'] = $arah[2];
      }

      // Mark : - Speaker
      if( floatval($value['ews_arus_speaker']) >= 0.10 && floatval($value['ews_teg_out_sirine']) >= 0.10 && floatval($value['ews_sirine_mute']) == 1 && $value['ews_arah'] != "NONE" ){
        $query['data'][$key]['speaker'] = "ON";
      }elseif (floatval($value['ews_arus_speaker']) < 0.10 && floatval($value['ews_teg_out_sirine']) < 0.10 && floatval($value['ews_sirine_mute']) == 1 && $value['ews_arah'] == "NONE") {
        $query['data'][$key]['speaker'] = "OFF";
      }elseif (floatval($value['ews_arus_speaker']) < 0.10 && floatval($value['ews_teg_out_sirine']) < 0.10 && floatval($value['ews_sirine_mute']) == 1  && $value['ews_arah'] != "NONE") {
        $query['data'][$key]['speaker'] = "RUSAK";
      }elseif (floatval($value['ews_arus_speaker']) < 0.10 && floatval($value['ews_teg_out_sirine']) < 0.10 && floatval($value['ews_sirine_mute']) == 0  && $value['ews_arah'] != "NONE") {
        $query['data'][$key]['speaker'] = "MUTE";
      }

    }
    return $query;
  }

  public function getDatum($id){
    $today = date("Y-m-d");
    $date1 = date_create($today);
    $sql = "SELECT *, REPLACE(SUBSTRING_INDEX(ews_km,'(',1),'jpl ','') ews_jpl , REPLACE(SUBSTRING_INDEX(ews_km,'( ', -1),')','') ews_kms FROM tb_ews WHERE ews_ip = '$id' ";
    $main = $this->func->db_execute($sql);
    $main['data'][0]['rambu_icon'] = array();
    $main['data'][0]['umur_alat'] = "";
   
    $str = $main['data'][0]['ews_rambu'];
    $str2 = explode(",", str_replace("\"", "", str_replace("]", "", str_replace("[", "", $str)))   );
    if(count($main['data']) > 0){
      $date2 = date_create($main['data'][0]['ews_install_year']);
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


}

?>