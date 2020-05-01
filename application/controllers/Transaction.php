<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));		
	}
	
	function maintenance(){
		$data = array(
			"parent" => "Transaction",
			"title" => "Maintenance",
			"desc" => ""
		);

		$this->load->view('template/header', $data);
		$this->load->view('transaction/maintenance', $data);
		$this->load->view('template/footer');
	}

	
}