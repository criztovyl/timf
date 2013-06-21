<?php
if(!isset($verified)){
	show_404();
}
?>
<h1>Bestätigung deiner eMail Adresse</h1>
<p>
<?php
echo $verified;
?>
</p>