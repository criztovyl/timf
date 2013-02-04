<?php
class Timf extends CI_Controller{
	public function about(){
		
	}	
	public function index(){
		echo ":D";
	}
	public function user(){
		$data['main']= "application/views/pages/profile.php";
		$data['left'] = "application/views/pages/empty.html";
		$data['right'] = "application/views/pages/empty.html";
		$data['title'] = "Timf";
		$this->load->view("templates/header", $data);		
		$this->load->view("templates/main", $data);
		$this->load->view("templates/footer", $data);
	}
}
?>