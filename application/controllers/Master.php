<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));		
	}
	
	function user(){
		$data = array("parent" => "Master","title" => "User","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/user', $data);
		$this->load->view('template/footer');
	}

	function menu(){
		$data = array("parent" => "Master","title" => "Menu","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/menu', $data);
		$this->load->view('template/footer');
	}

	function traffic(){
		$data = array("parent" => "Master","title" => "Traffic Light","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/traffic', $data);
		$this->load->view('template/footer');
	}

	function ews(){
		$data = array("parent" => "Master","title" => "EWS","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/ews', $data);
		$this->load->view('template/footer');
	}

	function warning(){
		$data = array("parent" => "Master","title" => "Warning Light","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/warning', $data);
		$this->load->view('template/footer');
	}

	function pju(){
		$data = array("parent" => "Master","title" => "PJU","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/pju', $data);
		$this->load->view('template/footer');
	}

	function icons(){
		$data = array("parent" => "Master","title" => "Icons","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/icons', $data);
		$this->load->view('template/footer');
	}

	function params(){
		$data = array("parent" => "Master","title" => "Parameter","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('master/params', $data);
		$this->load->view('template/footer');
	}
	
}