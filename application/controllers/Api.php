<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

require_once('Helper/Base.php');
require_once('Helper/Traffic.php');
require_once('Helper/Ews.php');
require_once('Helper/Warning.php');
require_once('Helper/Pju.php');
require_once('Helper/Admin.php');
require_once('Helper/Area.php');
require_once('Helper/Icon.php');
require_once('Helper/Dash.php');

class Api extends REST_Controller {

  public $mdb, $mdb2, $base, $tfc, $ews, $wrn, $pju, $adm, $area, $icon, $dash;
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->base = new Base();
    $this->tfc = new Traffic();
    $this->ews = new Ews();
    $this->wrn = new Warning();
    $this->pju = new Pju();
    $this->adm = new Admin();
    $this->area = new Area();
    $this->icon = new Icon();
    $this->dash = new Dash();
  }

//Authorize
//===========================================================================================

  private function auth(){
    $token = $this->input->get_request_header('x-token');
    if($token != '00043eb6617434cc5f357bbf692e53be'){
      $result = array(
        "kind" => "error",
        "status_code" => "400",
        "messages" => "Invalid Key",
        "data" => array()
      );
      header('Content-Type: application/json');
      echo json_encode($result);
      die();
    }
  }


  public function index_get($a = null, $b = null, $c = null, $d = null, $e = null, $f = null, $g = null){
    if(!$a){
      $r = array(
        "Hallo" => "Welcome to API index page",
        //"database" => $this->db->username . " " . $this->db->password . " " . $this->db->hostname . " " . $this->db->database
        //"prefix" => date('y') . time()
      );
    }else{
      $r = array(
        "kind" => "error",
        "status_code" => "400",
        "messages" => "Invalid Key",
        "data" => array()
      );
    }
    $this->response($r, 200);
  }


//Menus
//===========================================================================================
  public function menus_data_get(){
    $this->auth();
    $sql = "SELECT menu_code, menu_name, menu_link, menu_icon, menu_parent, menu_sequences,
    (SELECT menu_name FROM tb_menus b WHERE b.menu_code = a.menu_parent ) parent
    FROM tb_menus a ORDER BY menu_sequences ";
    $main = $this->base->db_execute($sql);
    $this->base->renderJSON($main);
  }

  public function menu_data_get(){
    $this->auth();
    $sql = "SELECT menu_code, menu_name, menu_link, menu_icon, menu_parent, menu_sequences
    FROM tb_menus WHERE menu_parent = '0' ORDER BY menu_sequences ";
    $main = $this->base->db_execute($sql);

    //$arr = $main;
    foreach ($main['data'] as $key => $value) {
      $sql2 = "SELECT menu_code, menu_name, menu_link, menu_icon, menu_parent, menu_sequences
      FROM tb_menus WHERE menu_parent = '" .  $value['menu_code'] .  "' ORDER BY menu_sequences ";
      $sub = $this->base->db_execute($sql2);
      $main['data'][$key]['menu_child'] = $sub['data'];
    }
    $this->base->renderJSON($main);
  }

  public function menus_get($params = null){
    if($params){
      $param = $params;
    }else{
      $param = 'admin';
    }
    $sql = "SELECT acc_id, adm_code, adm_pass, adm_name, adm_level, adm_image, acc_access,
            menu_code, menu_name, menu_link, menu_icon, menu_parent, menu_sequences, acc_active 
            FROM tb_admin_access
            LEFT JOIN tb_admin
            ON adm_code = acc_adm_code
            LEFT JOIN tb_menus ON acc_access = menu_code
            WHERE adm_code = '$param' AND menu_parent = '0' ORDER BY menu_sequences ";
    $main_menu = $this->base->db_execute($sql);

    foreach ($main_menu['data'] as $main) {
      // Query untuk mencari data sub menu
      $sql = "SELECT * FROM tb_menus
      LEFT JOIN tb_admin_access ON acc_access = menu_code
      WHERE acc_adm_code = '$param' AND menu_parent = '" . $main['menu_code'] . "' ORDER BY menu_sequences";
      $sub_menu = $this->base->db_execute($sql);

      // periksa apakah ada sub menu
      if (count($sub_menu['data']) > 0) {
        // main menu dengan sub menu
        echo "<li class='treeview'>" . anchor($main['menu_link'], '<i class="' . $main['menu_icon'] . '"></i><span>' . $main['menu_name'] .
          '</span><span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>');
        // sub menu nya disini
        echo "<ul class='treeview-menu'>";
        foreach ($sub_menu['data'] as $sub) {
          if($sub['acc_active'] == 'Y' ){
            echo "<li>" . anchor($sub['menu_link'], '<i class="' . $sub['menu_icon'] . '"></i><span>' . $sub['menu_name'] ."</span>" ) . "</li>";
          }else{
            //echo '<li><a href="" ng-click="" ><i class="' . $sub['menu_icon'] . '"></i><span>' . $sub['menu_name'] ."</span></a></li>";
          }
        }
        echo"</ul></li>";
      } else {
        // main menu tanpa sub menu
        echo "<li class='treeview'>" . anchor($main['menu_link'], '<i class="' . $main['menu_icon'] . '"></i><span>' . $main['menu_name'] . "</span>" ) . "</li>";
      }
    }    
  }

//Core
//===========================================================================================
  public function login_get($user, $pass) {
    // $this->auth();
    $this->base->renderJSON($this->adm->getLogin($user, $pass));
  }


//===========================================================================================
  //DASHBOARD

  //TRAFFIC LIGHT
  public function header_traffic_get($kecamatan){
    // $this->auth();
    $this->base->renderJSON($this->tfc->getHeaderTraffic($kecamatan));
  }
  public function traffic_get($ip){
    //$this->auth();
    $this->base->renderJSON($this->tfc->getTrafficIp($ip));
  }

  //EWS
  public function header_ews_get($kecamatan){
    // $this->auth();
    $this->base->renderJSON($this->ews->getHeaderEws($kecamatan));
  }

  public function ews_get($ip){
    // $this->auth();
    $this->base->renderJSON($this->ews->getEwsIp($ip));
  }

  //WARNING LIGHT
  public function header_warning_get($kecamatan, $project){
    //$this->auth();
    $this->base->renderJSON($this->wrn->getHeaderWrn($kecamatan, $project));
  }
  public function warning_get(){
    // $this->auth();
    $this->base->renderJSON($this->wrn->getWarningIp($ip));
  }


  //PJU
  public function pju_get(){
    $this->auth();
    $sql = "SELECT pju_ip, pju_pole, pju_loc_lat, pju_loc_lon, pju_loc_desc, 
    pju_duration, pju_status, pju_battery 
    FROM tb_pju 
    WHERE pju_ip = '12345' ";
    $result = $this->db_execute($sql);
    $this->renderJSON($result);
  }




//===========================================================================================
  //MASTER

  //USER
  public function user_get(){
    // $this->auth();
    $this->base->renderJSON($this->adm->getAllUser());
  }

  public function user_id_get($id){
    // $this->auth();
    $this->base->renderJSON($this->adm->getUserId($id));
  }

  public function user_post(){
    // $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->adm->saveUser($this->post));
  }

  public function user_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->adm->updateUser($this->post));
  }

  public function user_delete($id){
    $this->base->renderJSON($this->adm->deleteUser($id));
  }

  public function user_menu_data_get($id){
    // $this->auth();
    $this->base->renderJSON($this->adm->getMenuData($id));
  }

  public function user_menu_data_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->adm->saveMenuData($this->post));
  }

  public function user_menu_get($id){
    // $this->auth();
    $this->adm->getUserMenu($id);
  }

  public function user_menu_delete($id){
    return $this->base->renderJSON($this->adm->deleteMenu($id));
  }


  //AREA
  public function province_get() {
    $this->auth();
    $this->base->renderJSON($this->area->getProvince());
  }

  public function city_get($prov) {
    $this->auth();
    $this->base->renderJSON($this->area->getCity($prov));
  }

  public function district_get($city) {
    $this->auth();
    $this->base->renderJSON($this->area->getDistrict($city));
  }

  //MASTER
  //======================================================================================================================================

  //TRAFIC LIGHT
  public function m_traffic_get(){
    $this->auth();
    $this->base->renderJSON($this->tfc->get());
  }

  public function m_traffic_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->tfc->getId($id));
  }

  public function m_traffic_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->save($this->post));
  }

  public function save_from_upload_tl_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->saveUpload($this->post));
  }

  //khusus buat reset dari perpanjangan dan perpendekan
  public function m_traffic_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->reset($this->post));
  }

  //khusus buat update dari master
  public function master_traffic_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->update($this->post));
  }

  public function m_traffic_delete($id){
    //delete for detail
    $this->base->renderJSON($this->tfc->delete($id));
  }

  public function m_traffic_d_get($id){
    $this->auth();
    $this->base->renderJSON($this->tfc->getDetail($id));
  }

  public function m_traffic_d_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->saveDetail($this->post));
  }

  public function m_traffic_d_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->updateDetail($this->post));
  }

  public function history_tfc_get($ip){
    $this->auth();
    $this->base->renderJSON($this->tfc->getHistory($ip));
  }

  public function data_umum_tl_get($id){
    $this->auth();
    $this->base->renderJSON($this->tfc->getDatum($id));
  }

  public function save_history_tfc_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->saveHistory($this->post));
  }

  public function update_history_tfc_post($code){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->tfc->updateHistory($this->post, $code));
  }

  public function delete_history_tfc_delete($id){
    $this->base->renderJSON($this->tfc->deleteHistory($id));
  }

  //EWS
  public function m_ews_get(){
    $this->auth();
    $this->base->renderJSON($this->ews->get());
  }

  public function m_ews_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->ews->getId($id));
  }

  public function m_ews_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->ews->save($this->post));
  }

  public function m_ews_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->ews->update($this->post));
  }

  public function m_ews_delete($id){
    $this->base->renderJSON($this->ews->delete($id));
  }

  public function history_ews_get($ip){
    $this->auth();
    $this->base->renderJSON($this->ews->getHistory($ip));
  }

  public function save_history_ews_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->ews->saveHistory($this->post));
  }

  public function update_history_ews_post($code){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->ews->updateHistory($this->post, $code));
  }

  public function delete_history_ews_delete($id){
    $this->base->renderJSON($this->ews->deleteHistory($id));
  }

  public function save_from_upload_ews_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->ews->saveUpload($this->post, $code));
  }


  //WARNING LIGHT
  public function m_warning_get(){
    $this->auth();
    $this->base->renderJSON($this->wrn->get());
  }

  public function m_warning_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->wrn->getId($id));
  }

  public function m_warning_project_get(){
    $this->auth();
    $this->base->renderJSON($this->wrn->getProject());
  }

  public function m_warning_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->wrn->save($this->post));
  }

  public function m_warning_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->wrn->update($this->post));
  }

  //warning detail
  public function m_warning_d_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->wrn->saveDetail($this->post));
  }

  public function m_warning_d_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->wrn->updateDetail($this->post));
  }

  public function m_warning_d_delete($id){
    $this->base->renderJSON($this->wrn->deleteDetail($id));
  }

  public function m_warning_by_sn_get($id){
    $this->auth();
    $this->base->renderJSON($this->wrn->getDetailBySn($id));
  }

  public function m_warning_d_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->wrn->getDetailById($id));
  }

  //wl report
  public function data_umum_wl_get($id){
    $this->auth();
    $this->base->renderJSON($this->wrn->getDatum($id));
  }

  public function status_alat_get($sn){
    $this->auth();
    $this->base->renderJSON($this->wrn->getStatusAlat($sn));
  }


  //PJU
  public function m_pju_get(){
    $this->auth();
    $this->base->renderJSON($this->pju->get());
  }

  public function m_pju_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->pju->getId($id));
  }

  public function m_pju_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->pju->save($this->post));
  }

  public function m_pju_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->pju->update($this->post));
  }

  public function m_pju_delete($id){
    $this->base->renderJSON($this->pju->delete($id));
  }


  //ICONS
  public function m_icons_get(){
    $this->auth();
    $this->base->renderJSON($this->icon->get());
  }

  public function m_icons_id_get($id){
    $this->auth();
    $this->base->renderJSON($this->icon->getId($id));
  }

  public function m_icons_type_get($id){
    $this->auth();
    $this->base->renderJSON($this->icon->getType($id));
  }

  public function m_icons_post(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->icon->save($this->post));
  }

  public function m_icons_put(){
    $this->auth();
    $this->post = json_decode(file_get_contents('php://input'), true);
    $this->base->renderJSON($this->icon->update($this->post));
  }

  public function m_icons_delete($id){
    $this->base->renderJSON($this->icon->delete($id));
  }

  //=================================================================================================================================

  public function uploadFile_post(){
    $location = $_POST['directory'];
    $uploadfile = $_POST['fileName'];
    $uploadfilename = $_FILES['file']['tmp_name'];

    $message = $_FILES['file']['error'];
    if(move_uploaded_file($uploadfilename, $location.$uploadfile)){
      $res = array(
        "kind" => "success",
        "message" => "File successfully uploaded",
        "data"  => array(
          "location"    => $location,
          "uploadfile"  => $uploadfile,
        )
      );
      echo json_encode(array($res));    
    } else {
      $res = array(
        "kind" => "error",
        "message" => "Upload error",
        "reason" => $message,
        "data"  => array(
          "location"    => $location,
          "uploadfile"  => $uploadfile,
        )
      );
      echo json_encode(array($res));    
    }

  }


  //report
  public function inbox_get(){
    $this->base->renderJSON($this->dash->inbox());
  }

  public function dash_sum_get(){
    $this->base->renderJSON($this->dash->sumEws());
  }

  public function dash_sum_tl_get(){
    $this->base->renderJSON($this->dash->sumTfc());
  }

  public function dash_sum_wl_get(){
    $this->base->renderJSON($this->dash->sumWrn());
  }


  //EWS
  public function input_ews_get(){
    // $this->auth();
    $this->base->renderJSON($this->ews->inputEws());
  }

  public function rpt_ews_by_get($prov, $city, $dist){
    $this->base->renderJSON($this->ews->getEwsByArea($prov, $city, $dist));
  }


  public function rpt_ews_available_city_get(){
    $this->base->renderJSON($this->ews->getEwsAvailable());
  }

  public function rpt_ews_city_get($city){
    $this->base->renderJSON($this->ews->getEwsByCity($city));
  }

  public function rpt_ews_sn_old_get($sn){
    $this->base->renderJSON($this->ews->getEwsBySnOld($sn));
  }

  public function rpt_ews_sn_get($sn, $from, $to){
    $this->base->renderJSON($this->ews->getEwsBySn($sn, $from, $to));
  }


  //TL
  public function input_tl_get(){
    // $this->auth();
    $this->base->renderJSON($this->tfc->inputTfc());
  }

  public function rpt_tfc_by_get($prov, $city, $dist){
    $this->base->renderJSON($this->tfc->getTfcByArea($prov, $city, $dist));
  }

  public function rpt_tfc_sn_get($sn, $from, $to){
    $this->base->renderJSON($this->tfc->getTfcBySn($sn, $from, $to));
  }


  public function rpt_tl_available_ip_get(){
    $this->base->renderJSON($this->tfc->getTfcAvailable());
  }

  public function rpt_tl_ip_get($ip, $date){
    $this->base->renderJSON($this->tfc->getReportTfc($ip, $date));
  }


  //wl
  public function input_wl_get(){
    // $this->auth();
    $this->base->renderJSON($this->wrn->inputWrn());
  }

  public function rpt_wl_by_get($prov, $city, $dist){
    $this->base->renderJSON($this->wrn->getWrnByArea($prov, $city, $dist));
  }


/*=============================================================================================================================*/
  //versi apps 
  public function version_get($id){
    $this->auth();
    $this->base->renderJSON($this->dash->appVersion($id));
  }

  public function projects_get(){
    $this->auth();
    $this->base->renderJSON($this->dash->projects());
  }

  public function rambus_get(){
    $this->auth();
    $this->base->renderJSON($this->dash->rambus());
  }

  public function data_umum_get($id){
    $this->auth();
    $this->base->renderJSON($this->ews->getDatum($id));
  }

  public function maintenance_get($sn){
    $this->auth();
    $this->base->renderJSON($this->dash->maintenance($sn));
  }

  public function graphic_batt_day_get($sn){
    $this->base->renderJSON($this->dash->graphBattDay($sn));
  }

  public function graphic_batt_week_get($sn){
    $this->base->renderJSON($this->dash->graphBattWeek($sn));
  }

  public function graphic_pv_day_get($sn){
    $this->base->renderJSON($this->dash->graphPvDay($sn));
  }

  public function graphic_pv_week_get($sn){
    $this->base->renderJSON($this->dash->graphPvWeek($sn));
  }

  public function arah_kereta_get($sn){
    $this->base->renderJSON($this->dash->arahKereta($sn));
  }



    function ewsUrl_post() {
      $from = "inbox";
      $data = array('data'=> $this->input->get('data'));
      $this->Api_model->save_data_one_table($data,$from);

      file_get_contents("http://wantechsmart.com/index.php/api/input_ews");
      $this->response(array(
                            'result' => 'Success',
                            'var_result' => '1',
                            'var_message' => 'Success',
                            'data' => $data,
                            ), 200);
    }



}
?>