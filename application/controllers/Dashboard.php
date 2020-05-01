<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session'));
	}

	public function set_session($key, $values){
		$this->session->set_userdata($key, $values);
	}

	function index(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "Welcome",
			"desc" => "to traffic light monitoring system"
		);

		$this->load->view('template/header', $data);
		$this->load->view('dashboard/welcome', $data);
		$this->load->view('template/footer');
	}

	function scheduler(){
		$data = array(
			"parent" => "Scheduler",
			"title" => "Scheduler",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('dashboard/scheduler', $data);
		$this->load->view('template/footer');
	}

	function get_data($satu){
    header('Content-Type: application/json');
		$arr = array(
			"title" => "ini judul " . $satu,
			"subtitle" => "ini sub judul",
			"data" => $this->db->get("tb_province")->result()
		);
		echo json_encode($arr);
	}
	
	function traffic(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "Traffic Light",
			"desc" => ""
		);
		$this->load->view('template/header', $data);
		$this->load->view('dashboard/traffic', $data);
		$this->load->view('template/footer');
	}

	function ews(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "EWS",
			"desc" => ""
		);
		$this->load->view('template/header', $data);
		$this->load->view('dashboard/ews', $data);
		$this->load->view('template/footer');
	}

	function single_ews(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "EWS",
			"desc" => ""
		);
		$this->load->view('template/single_header', $data);
		$this->load->view('dashboard/ews', $data);
		$this->load->view('template/footer');
	}

	function warning(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "Warning Light",
			"desc" => ""
		);
		$this->load->view('template/header', $data);
		$this->load->view('dashboard/warning', $data);
		$this->load->view('template/footer');
	}

	function pju(){
		$data = array(
			"parent" => "Dashboard",
			"title" => "Penerangan Jalan Umum",
			"desc" => ""
		);
		$this->load->view('template/header', $data);
		$this->load->view('dashboard/pju', $data);
		$this->load->view('template/footer');
	}
	
}