<!DOCTYPE html>
<html>
<head>
<title>
<?php 
if(isset($title)){
    echo $title;
}
else{
    echo "Page Title";
}
?>
</title>
<meta charset="UTF-8">
<?php
if(isset($css)) {
	echo "<link rel='Stylesheet' href='".$this->config->item('base_url').$css."' type='text/css'>";
}
else {
	echo "<link rel='Stylesheet' href='css.css' type='text/css'>"; 
}
if(isset($js)) {
	if(is_array($js)) {
		foreach($js as $script){
			echo "<script type='text/javascript' src='".$this->config->item('base_url').$script."'></script>";
		}
	}
}
?>
<script type="text/javascript" src="/jquery.js"></script>
</head>
<body>