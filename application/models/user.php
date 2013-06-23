<?php
class user extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('type');
	}
	/**
	Get the ID of an user
	$user string The user
	return the ID or NULL if not a user*/
	public function getUserID($user) {
		if($user == 'self'){
			$user = $this->session->userdata("user");
		}
		$reply = $this->db->query("SELECT ID FROM timf_users WHERE eMail='".$user."'");
		foreach($reply->result() as $row){
			return $row->ID;
		}
		return NULL;
	}
	public function update($update) {
		if(!self::getUserID($this->session->userdata("user"))){
			return false;
		}
		else {
			$id = self::getID();
			$this->db->query("INSERT INTO timf.timf_users_updates values(NULL, ".$id.", CURRENT_TIMESTAMP, '".$update."')");
			return true;
		}
	}
	public function getLastUpdates($type, $class, $limit = 10) {
		$id = self::getID();
		$response = $this->db->query("SELECT * FROM timf_users_updates WHERE User=".$id." ORDER BY Date DESC LIMIT 0, ".$limit);
		$str = '';
		foreach($response->result() as $update){
   		$str .= "<".$type." class=\"".$class."\">";
   		$str .= "<div><div style=\"text-align:right; padding:0; margin-bottom: 0; color:gray;\">".$update->Date."</div>";
   		$str .= "<div style=\"text-align:left;\">".$update->Update."</div></div>";
   		$str .= "</".$type.">\n";
   	}
	   return $str;
	}
	public function getUser(){
		return $this->session->userdata("user");
	}
/*	public function getConfig($user = 'self', $type = 'json') {
		if($user == 'self'){
			$id = self::getID();
			$response = $this->db->query("SELECT Config FROM timf_users WHERE ID=".$id);
			if($response->num_rows() == 1){
				foreach($response->result() as $row){
					if($type == 'json') {
						return json_encode(json_decode($row->Config));
					}
					elseif($type == 'php') {
						return json_decode($row->Config, true);
					}
					elseif($type == 'raw') {
						return var_dump(json_decode($row->Config, true));
					}	
					else {
						return self::json_err('Unknown Type!', $user);
					}
				}			
			}
			else {
				return self::json_err('Database Error.');	
			}
		}
		elseif(self::isUser($user)) {
			$id = self::getID($user);
			$response = $this->db->query('SELECT Config FROM timf_users WHERE ID='.$id);
			foreach($response->result_array() as $row){
				$json = json_decode($row['Config'], true);
				if(!isset($json['pub'])){
					$json['pub'] = array('show' => false);
				}
				$json = $json['pub'];
				if($type == 'json') {
					return json_encode($json);
				}
				elseif($type == 'php') {
					return $json;
				}
				elseif($type == 'raw') {
					return var_dump($json);
				}	
				else {
					return self::json_err('Unknown Type!', $user);
				}
			}
		}
		else {
			return self::json_err('Unknown User!', $user);
		}
	}
	public function setConfig($json){
		$id = self::getID();
		//$json_old = self::getConfig('self', 'json');
		//$json_new = array_merge_recursive($json_old, $json);
		//$json = json_encode($json);
		$this->db->query('UPDATE timf_users SET Config=\''.$json.'\' WHERE ID='.$id);
		return array('success' => true);
	}*/
	public function setAvatar($json){
		$id = self::getID();
		$url = $json['url'];
		$this->db->query('UPDATE timf_users SET Avatar="url" WHERE ID='.$id);
		$this->db->query('UPDATE timf_users SET AvatarURL="'.$url.'" WHERE ID='.$id);
		return array('success' => true);
	}
	public function getAvatar($type = 'json') {
		if($this->session->userdata('loggedin')){
			$id = self::getID();
			$response = $this->db->query('SELECT AvatarURL FROM timf_users WHERE ID='.$id);
			if($response->num_rows() == 1){
				foreach($response->result() as $row){
					$url;
					if($row->AvatarURL == ""){
						$url = base_url('images/Smile_timf.png');
					}
					else {
						$url = $row->AvatarURL;	
					}
					if($type == 'json'){
						return json_encode(array('success' => true, 'url' => $url, 'tag' => '<img src="'.$url.'" alt="Avatar">'));
					}
					elseif($type == 'tag') {
						return '<img src="'.$url.'" alt="Avatar">';
					}
					elseif($type == 'url') {
						return $url;
					}
					else {
						return json_err('Unknown Type!', array('type' => $type));
					}
				}
			}
			else {
				return json_err('Database Error.');
			}
		}
		else {
			return json_err('Not Logged in!');
		}
	}
/*Database*/
	/**
	Get a value form the users table.
	$value string the field
	$type string optimal return type ('json', 'raw'(=var dump), 'php'(=Array)). Standart json.
	$user string optimal the user. Leave blank for current user.
	*/
	public function get($value, $type = 'json', $user = 'self') {
		if	($this->session->userdata('loggedin')){
			if($user != 'self') {
				return self::getConfig($user, $type);
			}
			elseif($value == 'ALL'){
				$id = self::getID();
				$response = $this->db->query('SELECT * FROM timf_users WHERE ID='.$id);
				foreach($response->result_array() as $row){
					if(isset($row['Config'])){
						$row['Config'] = json_decode($row['Config']);
					}
					return convert($row, $type);
				}
			}
			elseif(self::hasValue($value)){
				$id = self::getID();
				$response = $this->db->query('SELECT '.$value.' FROM timf_users WHERE ID='.$id);
				foreach($response->result_array() as $row){

					$result = $row[$value];
					
					if($value == 'Config'){
					 $result = json_decode($result);
					}
					return convert($result, $type);
				}			
			}
			else {
			 return json_err('Unknown Value!'); 
			}
		}
		else {
			return json_err('Not Logged in!');
		}
	}
/*---------------------------------------------------------------------------------------------*/
/*User*/
	/**
	Try to Login.
	$user string the user/the email
	$auth string SHA1 Hash of the password
	*/
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
	/**
	Check if the user exists in the DB
	user string the user
	*/
	public function isUser($user) {
		$response = $this->db->query('SELECT eMail FROM timf_users');
		foreach($response->result() as $row){
			if($row->eMail == $user){
			 return true;
			}
		}
		return false;
	}
/*Tools*/
	/*Errors*/
	public static $LOGIN_NOUSER = 0;
	public static $LOGIN_DBERROR = 1;
	public static $LOGIN_WRONGAUTH = 3;
	public static $LOGIN_SUCCESS = 2;
	public static $DBERROR = 4;
	
	/**
	Get Error Message
	$num int Error Number
	*/
	public function getText($num){
		if($num == user::$LOGIN_NOUSER){
			return "Dieser Nutzer existiert nicht.";
		}
		elseif($num == user::$LOGIN_DBERROR) {
			return "Datenbank Fehler: Mehr als ein Nutzer mit diesem Namen vorhanden.";
		}
		elseif($num == user::$LOGIN_WRONGAUTH) {
			return "Falsches Passwort!";
		}
		elseif($num == user::$LOGIN_SUCCESS) {
			return "Login erfolgreich.";
		}
	}

	/*
	Check if a field exists in the users table
	$value string the field
	*/
	public function hasValue($value){
		return $this->db->field_exists($value, 'users');
	}
	/**
	Get the ID of a user
	$user string optimal the user. leave blank for current user.
	*/
	public function getID($user = 'self') {
		return self::getUserID($user);
	}
}
?>