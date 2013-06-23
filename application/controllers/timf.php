<?php
class timf extends CI_Controller{
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('type');
		$this->load->model('user'); 
		$this->load->model('timf_data');
	}
   public function view($page = "start", $extra = ""){
   	 $data = array();
   	 $data['extra'] = $extra;
   	 $data['js'] = array();
   	 $data['css'] = array();
        if(file_exists("application/views/pages/".$page.".php")){
	     		if(file_exists("js/".$page.".js")){
	     			$data['js'] = array_merge(array("js/".$page.".js"), $data['js']);
	     		}
	     		if(file_exists("css/".$page.".css")){
	     			$data['css'] = array_merge(array("css/".$page.".css"), $data['css']);
	     		}
        		if($page == "profile"){
        			if(!$this->session->userdata('loggedin')){
        				self::view('start', 'Du must angemeldet sein um dein Profil besuchen zu können.');
        				return;
        			}
	        		else {
	        			$data['updates'] = $this->user->getLastUpdates("li", "updates", 20);
	        		}
        		}
        		elseif($page == "config"){
        			if(!$this->session->userdata('loggedin')){
        				self::view('start', 'Du must angemeldet sein um dein Profil bearbeiten zu können.');
        				return;
	     			}
        		}
        		elseif($page == "public") {
        			$user = urldecode($extra);
        			if($extra == ''){
        				self::view("start", "Nutzer nicht gefunden :(");
        				return;
        			}
        			elseif(!$this->user->isUser($user)){
        				self::view("start", "Nutzer nicht gefunden :(");
        				return;
        			}
        			else {
        				$data['pub'] = $this->user->getConfig($user, 'php');
	        			$data['user'] = $user;
        			}
        		}
            $data['title'] = $page;
            $data['css'] = array_merge(array("css/timf.css"), $data['css']);
            $data['js'] = array_merge(array("js/jquery.js", "js/timf.js"), $data['js']);
            $this->load->view("templates/begin", $data);
            $this->load->view("pages/".$page, $data);
            $this->load->view("templates/footer", $data);
        }
        else{
            self::view("start", "Seite nicht gefunden :(");
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
				echo "Kein Passwort angegeben!";
   		}
   }
   public function baseurl() {
   	echo $this->config->item('base_url');	
   }
   public function update(){
   	if($this->session->userdata('loggedin')){
	   	if(isset($_POST['update'])) {
	   		if(!$this->user->update($_POST['update'])){
					echo $this->session->userdata('last_error');	   		
	   		}
	   		else {
	   			echo "Done.";
	   		}
	   	}
	   	else {
				self::view("profile", "Du hast keinen Text als neuen Status eingegeben.");
	   	}
   	}
   	else {
   		self::view("start", "Du musst angemeldet sein um deinen Status zu erneuern.");
   	}
   }
   public function lastUpdates($type, $class = "updates", $limit = 10){
		echo $this->user->getLastUpdates($type, $class, $limit);
   }
   public function logout() {
   	$this->session->sess_destroy();
   	redirect(base_url('timf/view/start'), "location");
   }
   public function config($action = 'get', $type = 'json'){
   	echo convert(array('success' => false, 'response' => 'API down.'), $type);
   	/*if($this->session->userdata('loggedin')) {
	   	if($action == "get") {
	   		echo convert($this->timf_data->getConfig('self'), $type);
	   	}
	   	elseif($action == "update") {
	   		if(isset($_POST['data'])) {
	   			echo $this->user->setConfig($_POST['data']);
	   		}
	   		else {
	   			echo json_err('Missing Data!');
	   		}
	   	}
	   	elseif($action == "avatar") {
	   		if(isset($_POST['json'])){
	   			echo $_POST['json']."\n";
		   		echo $this->user->setAvatar($_POST['json']);
	   		}
	   		else{
	   			echo json_encode(array('success' => false, 'response' => 'Missing Data!'));
	   		}
	   	}
		   else {
		   	echo json_encode(array('success' => false, 'response' => 'Unknown Action!'));
		   }
   	}
   	else {
   		echo json_encode(array('success' => false, 'response' => 'Not Logged in!'));
   	}*/
   }
   public function avatar($type = 'json') {
   	echo $this->user->getAvatar($type);	
   }
   public function get($value, $type = 'json', $user = 'self') {
   	$user = urldecode($user);
   	echo convert($this->timf_data->getData($value, $user), $type);
  	}
	public function doit() {
		echo "!";
	}
}
?>