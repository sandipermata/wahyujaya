<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access extends CI_controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));		
	}
	
	function user(){
		$data = array("parent" => "Access","title" => "User","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('access/user', $data);
		$this->load->view('template/footer');
	}

	function menu(){
		$data = array("parent" => "Access","title" => "Menu","desc" => "");
		$this->load->view('template/header', $data);
		$this->load->view('access/menu', $data);
		$this->load->view('template/footer');
	}
	
}