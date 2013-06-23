<?php
	/**
	Convert a variable to json or text/raw(=var_dump) or keep php-variable
	*/
	function convert($data, $type) {
		if($type == 'json') {
			return json_encode($data);
		}
		elseif($type == 'raw'){
		 return var_dump($data);
		}
		elseif($type == 'php'){
			return $data;
		}
		else {
			return json_err('Unknown Type!', array('type' => $type));
		}
	}
	/**
	Return Error in JSON Format.
	(for AJAX)
	$err string error message
	$user string optimal the user. Standard ``
	*/
	function json_err($err, $extra = array()) {
		return json_encode(array('success' => false, 'response' => $err, 'extra' => $extra));
	}
?>