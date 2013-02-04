<?php
class internals extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library("session");
		$this->load->helper('captcha');
	}
	public function register($email, $password, $first, $last){
		$auth = sha1(TIMF_PASSWORD_SALT.$password);
		$this->db->query("Create Table if not exists timf.verify (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, VerifyKey varchar(40), Auth varchar(40), First varchar(30), Last varchar(30), eMail varchar(40))");
		$key = sha1(rand());
		$this->db->query("INSERT INTO verify (Auth, VerifyKey, First, Last, eMail) values('".$auth."', '".$key."', '".$first."',
		 '".$last."', '".$email."')");
		mail($email, "Bitte bestätige deine eMail", "http://v.chsc.de/timf/Internal/verify/".$key);
		return "Deine Bestätigungsmail wurde versendet.";
		 
	}
	public function verify($key){
		$email;
		$auth;
		$first;
		$last;
		$query = $this->db->query("Select * from verify where VerifyKey='".$key."'");
		if($query->num_rows() > 1){
			return "Datenbankfehler: Doppelter Bestätigungsschlüssel.";
		}
		else if ($query->num_rows() < 1){
			return "Unbekannter Bestätigungsschlüssel.";
		}
		else{
			foreach($query->result() as $row){
				$email = $row->eMail;
				$auth = $row->Auth;
				$first = $row->First;
				$last = $row->Last;
				$this->db->query("INSERT INTO timf_users (Auth, First, Last, eMail) values('".$auth."', '".$first."',
			 	'".$last."', '".$email."')");
			  	mail($email, "eMail Bestätigt ;)", "Du kannst dich jetzt auf http://v.chsc.de/timf/welcome/start mit dieser eMail Adresse und deinem Passwort anmelden.");
			 	return "Deine eMail wurde Bestätigt. Du kannst dich jetzt mit deiner eMail Adresse und deinem Passwort anmelden.";
			}	
		}
	}
	public function getAuth($email){
		$email = str_replace("%40", "@", $email);
		$query = $this->db->query("SELECT Auth from timf_users where email='".$email."'");
		if($query->num_rows() < 0){
		return false;		
		}
		else if($query->num_rows() > 1){
			return false;
		}
		else if($query->num_rows() == 1){
			foreach($query->result() as $row){
				$auth = $row->Auth;
			}
			return $auth;
		}
	}
	public function session_init(){
		$array = array("loggedin_true"=>true);
		$this->session->set_userdata($array);
	}
	public function session(){
		
	}
}
?>