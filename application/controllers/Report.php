<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));		
	}
	
	function traffic(){
		$data = array(
			"parent" => "Report",
			"title" => "Traffic Light",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('report/traffic', $data);
		$this->load->view('template/footer');
	}

	function single_traffic(){
		$data = array(
			"parent" => "Report",
			"title" => "Traffic Light",
			"desc" => ""
		);

		$this->load->view('template/single_header', $data);
		$this->load->view('report/traffic_mobile', $data);
		$this->load->view('template/footer');
	}

	function ews(){
		$data = array(
			"parent" => "Report",
			"title" => "EWS",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('report/ews', $data);
		$this->load->view('template/footer');
	}

	function single_ews(){
		$data = array(
			"parent" => "Report",
			"title" => "EWS",
			"desc" => ""
		);

		$this->load->view('template/single_header', $data);
		$this->load->view('report/ews_mobile', $data);
		$this->load->view('template/footer');
	}

	function warning(){
		$data = array(
			"parent" => "Report",
			"title" => "Warning Light",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('report/warning', $data);
		$this->load->view('template/footer');
	}

	function pju(){
		$data = array(
			"parent" => "Report",
			"title" => "PJU",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('report/pju', $data);
		$this->load->view('template/footer');
	}
	
}