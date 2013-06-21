<?php
class user extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public static $LOGIN_NOUSER = 0;
	public static $LOGIN_DBERROR = 1;
	public static $LOGIN_WRONGAUTH = 3;
	public static $LOGIN_SUCCESS = 2;
	public function login($user, $auth) {
		$user = str_replace("%40", "@", $user);
		$query = "SELECT Auth FROM timf_users WHERE eMail='".$user."'";
		$reply = $this->db->query($query);
		if($reply->num_rows() > 0){
			if($reply->num_rows() == 1){
				$authDB = '2';
				foreach($reply->result() as $row){
								$authDB = $row->Auth;	
				}
				if($auth == $authDB) {
					return 2;
				}
				else {
					return 3;
				}
			}
			else {
				return 1;
			}
		}
		else {
			return 0;
		}
	}
	public function getText($num){
		if($num == user::$LOGIN_NOUSER){
			return "Dieser Nutzer existiert nicht.";
		}
		elseif($num == user::$LOGIN_DBERROR) {
			return "Datenbank Error: Mehr als ein Nutzer mit diesem Namen vorhanden.";
		}
		elseif($num == user::$LOGIN_WRONGAUTH) {
			return "Falsches Passwort!";
		}
		elseif($num == user::$LOGIN_SUCCESS) {
			return "Login erfolgreich.";
		}
	}
}
?>