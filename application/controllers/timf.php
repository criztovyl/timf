<?php
class timf extends CI_Controller{
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('user');
	}
   public function view($page = "start"){
   	 $data = array();
        if(file_exists("application/views/pages/".$page.".php")){
        		if($page == "profile"){
        			if($this->session->userdata('loggedin')){
        			
        			}
        			else {
        				$page = 'start';
        				$data['extra'] = 'You must Login to see your Profile Page.';
        			}
        		}
            $data['title'] = $page;
            $data['css'] = "/css/timf.css";
            $data['js'] = array("/js/jquery.js", "/js/timf.js");
            $this->load->view("templates/begin", $data);
            $this->load->view("pages/".$page);
            $this->load->view("templates/footer", $data);
        }
        else{
            echo "Page not found :(";
        }
   }
   public function login($user) {
   		if(isset($_POST['auth'])){
   			$auth = $_POST['auth'];
	   		$user = str_replace('%40', '@', $user);
	   		$reply = $this->user->login($user, $auth);
	   		if($reply == user::$LOGIN_SUCCESS) {
	   			$this->session->set_userdata(array('user' => $user, 'loggedin' => true));
	   			echo "true";
	   		}
	   		else{
	   			echo $this->user->getText($reply);
	   		}
   		}
   		else{
				echo "Kein Passwort angegeben!"
   		}
   }
   public function baseurl() {
   	echo $this->config->item('base_url');	
   }
   public function update($update){
   
   }
public function doit() {
	echo "!";
}
}
?>