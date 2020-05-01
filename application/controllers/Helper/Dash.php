<?php

require_once('Base.php');

class Dash {

  private $func;
  function __construct(){
    $this->func = new Base();
  }

  public function inbox(){
    $sql = "SELECT * FROM inbox ORDER BY id_inbox DESC";
    return $this->func->db_execute($sql);
  }

  public function sumEws(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT pending_ews, berhasil_ews, last_sync_ews, (berhasil_ews / (pending_ews + berhasil_ews) * 100 ) progress_ews FROM (
            (SELECT COUNT(1) pending_ews FROM inbox WHERE `data` LIKE '%EWS%' ) pending_ews,
            (SELECT COUNT(1) berhasil_ews FROM inbox_archieve_ews WHERE `data` LIKE '%EWS%' ) berhasil_ews,
            (SELECT last_sync last_sync_ews FROM inbox_archieve_ews WHERE `data` LIKE '%EWS%' ORDER BY id_inbox DESC LIMIT 1 ) last_sync_ews
          )";
    $main = $this->func->db_execute($sql);

    if( count($main['data']) > 0 ){
      $kemarin = date('Y-m-d', strtotime('-1 days', strtotime(Date('Y-m-d')) ));
      $today = Date('Y-m-d');

      if(date("Y-m-d", strtotime($main['data'][0]['last_sync_ews'])) == $kemarin) {
        $main['data'][0]['last_sync_2_ews'] = "kemarin " . date("H:i", strtotime($main['data'][0]['last_sync_ews']));
      }else if(date("Y-m-d", strtotime($main['data'][0]['last_sync_ews'])) == $today){
        $main['data'][0]['last_sync_2_ews'] = "hari ini " . date("H:i", strtotime($main['data'][0]['last_sync_ews']));
      }else{
        $main['data'][0]['last_sync_2_ews'] = date("d M", strtotime($main['data'][0]['last_sync_ews'])) . " " . date("H:i", strtotime($main['data'][0]['last_sync_ews']));
      }
    }
    return $main;
  }

  public function sumTfc(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT pending_tl, berhasil_tl, last_sync_tl, (berhasil_tl / (pending_tl + berhasil_tl) * 100 ) progress_tl FROM (
            (SELECT COUNT(1) pending_tl FROM inbox WHERE `data` LIKE '%TRAFFIC%' ) pending_tl,
            (SELECT COUNT(1) berhasil_tl FROM inbox_archieve_tfc WHERE `data` LIKE '%TRAFFIC%' ) berhasil_tl,
            (SELECT last_sync last_sync_tl FROM inbox_archieve_tfc WHERE `data` LIKE '%TRAFFIC%' ORDER BY id_inbox DESC LIMIT 1 ) last_sync_tl
          )";
    $main = $this->func->db_execute($sql);

    if( count($main['data']) > 0 ){
      $kemarin = date('Y-m-d', strtotime('-1 days', strtotime(Date('Y-m-d')) ));
      $today = Date('Y-m-d');

      if(date("Y-m-d", strtotime($main['data'][0]['last_sync_tl'])) == $kemarin) {
        $main['data'][0]['last_sync_2_tl'] = "kemarin " . date("H:i", strtotime($main['data'][0]['last_sync_tl']));
      }else if(date("Y-m-d", strtotime($main['data'][0]['last_sync_tl'])) == $today){
        $main['data'][0]['last_sync_2_tl'] = "hari ini " . date("H:i", strtotime($main['data'][0]['last_sync_tl']));
      }else{
        $main['data'][0]['last_sync_2_tl'] = date("d M", strtotime($main['data'][0]['last_sync_tl'])) . " " . date("H:i", strtotime($main['data'][0]['last_sync_tl']));
      }
    }
    return $main;
  }

  public function sumWrn(){
    date_default_timezone_set('Asia/Jakarta');
    $sql = "SELECT pending_wl, berhasil_wl, last_sync_wl, (berhasil_wl / (pending_wl + berhasil_wl) * 100 ) progress_wl FROM (
            (SELECT COUNT(1) pending_wl FROM inbox WHERE `data` LIKE '%WL%' ) pending_wl,
            (SELECT COUNT(1) berhasil_wl FROM inbox_archieve_wrn WHERE `data` LIKE '%WL%' ) berhasil_wl,
            (SELECT last_sync last_sync_wl FROM inbox_archieve_wrn WHERE `data` LIKE '%WL%' ORDER BY id_inbox DESC LIMIT 1 ) last_sync_wl
          )";
    $main = $this->func->db_execute($sql);

    if( count($main['data']) > 0 ){
      $kemarin = date('Y-m-d', strtotime('-1 days', strtotime(Date('Y-m-d')) ));
      $today = Date('Y-m-d');

      if(date("Y-m-d", strtotime($main['data'][0]['last_sync_wl'])) == $kemarin) {
        $main['data'][0]['last_sync_2_wl'] = "kemarin " . date("H:i", strtotime($main['data'][0]['last_sync_wl']));
      }else if(date("Y-m-d", strtotime($main['data'][0]['last_sync_wl'])) == $today){
        $main['data'][0]['last_sync_2_wl'] = "hari ini " . date("H:i", strtotime($main['data'][0]['last_sync_wl']));
      }else{
        $main['data'][0]['last_sync_2_wl'] = date("d M", strtotime($main['data'][0]['last_sync_wl'])) . " " . date("H:i", strtotime($main['data'][0]['last_sync_wl']));
      }
    }
    return $main;
  }


  public function appVersion($id){
    $hsl = $this->func->db_execute("SELECT max(appVersion) versi FROM tb_versiapps WHERE appName='$id'");
    if(count($hsl['data']) > 0){
      $maxV = $hsl['data'][0]['versi'];

      $wheres = array("AND" => array("appVersion" => $maxV, "appName" => $id ));
      $hasil = $this->func->select_where("tb_versiapps", null, $wheres);
      return $hasil;
    }else{
      return $hsl;
    }
  }

  public function projects(){
    return $this->func->select_all("tb_project");
  }

  public function rambus(){
    return $this->func->select_all("tb_rambu");
  }

  public function maintenance($sn){
    return $this->func->select_where("tb_detail_maintenance", null, array("mnt_sn_code" => $sn ) );
  }

  public function graphBattDay($sn){
    $today = date('Y-m-d');
    $sql = "SELECT ews_sn, DATE_FORMAT(ews_rpt_date,'%H:%i:%s') jam, ews_battery_percent FROM tb_rpt_ews
            WHERE ews_sn = '$sn'
            AND DATE_FORMAT(ews_rpt_date,'%Y-%m-%d') = '$today'
            ORDER BY ews_rpt_date";
    return $this->func->db_execute($sql);
  }

  public function graphBattWeek($sn){
    $today = date('Y-m-d');
    $this->func->db_execute("SET lc_time_names = 'id_ID';");
    $sql = "SELECT ews_sn, DAYNAME(ews_rpt_date) hari, DATE_FORMAT(ews_rpt_date,'%Y-%m-%d') tanggal, AVG(ews_battery_percent) rata FROM tb_rpt_ews
            WHERE ews_sn = '$sn'
            AND ews_rpt_date > (CURDATE() - INTERVAL 7 DAY)
            GROUP BY DATE_FORMAT(ews_rpt_date,'%Y-%m-%d');";
    return $this->func->db_execute($sql);
  }

  public function graphPvDay($sn){
    $today = date('Y-m-d');
    $sql = "SELECT ews_sn, DATE_FORMAT(ews_rpt_date,'%H:%i:%s') jam, ews_tag_pv FROM tb_rpt_ews
            WHERE ews_sn = '$sn'
            AND DATE_FORMAT(ews_rpt_date,'%Y-%m-%d') = '$today'
            ORDER BY ews_rpt_date";
    return $this->func->db_execute($sql);
  }

  public function graphPvWeek($sn){
    $today = date('Y-m-d');
    $this->func->db_execute("SET lc_time_names = 'id_ID';");
    $sql = "SELECT ews_sn, DAYNAME(ews_rpt_date) hari, DATE_FORMAT(ews_rpt_date,'%Y-%m-%d') tanggal, AVG(ews_tag_pv) rata FROM tb_rpt_ews
            WHERE ews_sn = '$sn'
            AND ews_rpt_date > (CURDATE() - INTERVAL 7 DAY)
            GROUP BY DATE_FORMAT(ews_rpt_date,'%Y-%m-%d');";
    return $this->func->db_execute($sql);
  }

  public function arahKereta($sn){
    $sql = "SELECT ews_sn, ews_arah, ews_rpt_date, ews_loc_desc, ews_area FROM v_last_ews_rpt
            LEFT JOIN tb_ews ON ews_ip = ews_sn
            WHERE ews_sn = '$sn'";
    return $this->func->db_execute($sql);
  }




}

?>