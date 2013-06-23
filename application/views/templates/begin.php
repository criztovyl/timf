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
	if(is_array($css)){
		foreach($css as $style){
			echo "<link rel='Stylesheet' href='".base_url($style)."' type='text/css'>\n";
		}
	}
	else {
		echo "<link rel='Stylesheet' href='".base_url($css)."' type='text/css'>\n";
	}
}
else {
	echo "<link rel='Stylesheet' href='css.css' type='text/css'>\n"; 
}
if(isset($js)) {
	if(is_array($js)) {
		foreach($js as $script){
			echo "<script type='text/javascript' src='".base_url($script)."'></script>\n";
		}
	}
}
?>
<script type="text/javascript" src="/jquery.js"></script>
</head>
<body>