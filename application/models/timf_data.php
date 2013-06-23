<?php
class timf_data extends CI_Model{
	public function __construct() {
		parent::__construct();
		$this->load->model('user');
	}
	public function getData($field = 'ALL', $user = 'self') {
		if($user == 'self'){
			$user = $this->user->getUser();
		}
		if(!$this->db->field_exists($field, 'users')){
			if($field != 'ALL'){
				return array('success' => false, 'response' => 'Unknown Field!', 'extra' => array('field' => $field));
			}
		}
		if($this->user->isUser($user)){
			$id = $this->user->getUserID($user);
			if($field == 'ALL'){
				$response = $this->db->query('SELECT * FROM timf_users WHERE ID='.$id);
				$result = array();
				foreach($response->result_array() as $row){
					$result = $row;
					break;
				}
				foreach($result as $key => $value){
					if($key == 'Config'){
						 $result[$key] = json_decode(json_encode(json_decode($value, true), JSON_FORCE_OBJECT));
					}
				}
				return array('success' => true, 'data' => $result);
			}
			$response = $this->db->query('SELECT '.$field.' FROM timf_users WHERE ID='.$id);
			foreach($response->result_array() as $row){
				if($field == 'Config'){
					$data = json_decode(json_encode(json_decode($row[$field], true), JSON_FORCE_OBJECT));
					return array('success' => true, 'data' => $data);
				}
				return array('success' => true, 'data' => $row[$field]);
			}
		}
	}
	public function updateData($field, $data, $user = 'self') {
		if($user == 'self'){
			$user = $this->user->getUser();
		}
		if(!$this->db->field_exists($field, 'users')){
			if($field != 'ALL'){
				return array('success' => false, 'response' => 'Unknown Field!', 'extra' => array('field' => $field));
			}
		}
		if($field == 'ALL'){
			if(!is_array($data)){
				return array('success' => false, 'response' => 'Wrong Data Format!', 'extra' => array('needed' => 'array'));
			}
		}
		if($this->user->isUser($user)){
			$id = $this->user->getUserID($user);
			if($field == 'ALL'){
				$fields = $this->db->list_fields('users');
				foreach($fields as $db_field){
					if(isset($data[$db_field])){
						$this->db->query('UPDATE timf_users SET '.$db_field.'='.$data[$db_field].' WHERE ID='.$id);
					}
				}
				return array('success' => true);
			}
			$this->db->query('UPDATE timf_users SET '.$field.'='.$data.' WHERE ID='.$id);
			return array('success' => true);
		}
	}
}
?>