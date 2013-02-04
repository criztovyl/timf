<?php
class Internal extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model("internals");
	}
	/**
	* Register a User, all Data is got via POST
	*/
	public function register(){
		$this->load->helper('email');
		if(isset($_POST['password']) && isset($_POST['email'])){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$first = "";
			if(isset($_POST['first'])){
				$first = $_POST['first'];
			}
			$last = "";
			if(isset($_POST['last'])){
				$last = $_POST['last'];
			}
			if(valid_email($email)){
				echo $this->internals->register($email, $password, $first, $last);
			}
			else{
				echo "Ungültige eMail Adresse!";
			}			
		}
		else{
			echo "keine Daten angegeben!";
		}
	}
	public function verify($key){
		$data['main']= "application/views/pages/verify.php";
		$data['left'] = "application/views/pages/empty.html";
		$data['right'] = "application/views/pages/empty.html";
		$data['title'] = "Bestätigung deiner eMail Adresse";
		$data['verified'] = $this->internals->verify($key);
		$this->load->view("templates/header", $data);		
		$this->load->view("templates/main", $data);
		$this->load->view("templates/footer", $data);
	}
	public function Script($script){
		if(file_exists('application/libraries/js/'.$script.'.js')){
			include ('application/libraries/js/'.$script.'.js');
		}
		else{
			include ('application/libraries/js/missing.js');
		}
	}
	public function Snippet($snippet){
		if(file_exists('application/libraries/snippets/'.$snippet.'.html')){
			include ('application/libraries/snippets/'.$snippet.'.html');
		}
		else{
			include ('application/libraries/snippets/missing.html');
		}
	}
	public function Login($email){
		if(isset($_POST['password'])){
				$auth = $this->internals->getAuth($email, $_POST['password']);
			if(!$auth){
				echo 0;
			}
			else{
				$auth_ = sha1(TIMF_PASSWORD_SALT.$_POST['password']);
				if($auth_ == $auth){
					echo 11;
					
				}
				else{
					echo 10;
				}
			}
		}
		else{
			echo -1;
		}
	}
	public function Test($email, $password){
		$auth = $this->internals->check($email, $password);
		if(!$auth){
			echo 0;
		}
		else{
			$auth_ = sha1(TIMF_PASSWORD_SALT.$password);
			if($auth_ == $auth){
				echo 11;
			}
			else{
				echo 10;
			}
		}
	}
	public function session_init(){
		$this->internals->session_init();
	}
	public function doit(){
		echo $this->internals->session();
	}
	public function captcha(){
		$this->internals->captcha();
	}
}
?>