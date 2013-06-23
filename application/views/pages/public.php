<?php
var_dump($pub);
	if(isset($pub['show'])){
		if($pub['show'] == 'false') {
			echo $user." hat sein öffentliches Profil deaktiviert.";
			return;
		}
	}
	if(!isset($pub)){
		return;
	}
	if($pub['firstName']['show']){
		$user = $pub['firstName']['value']." ";
		echo "!";
	}
		if($pub['lastName']['show']){
		$user .= $pub['lastName']['value'];
	}
?>
<div class="header">
<h1>Öffentliches Profil von 
<?php echo $user;?></h1>
</div>
<div>
	<div class="cols drop">
		<div class="cols nav drop">&nbsp;</div>
		<div class="cols nav content right">
		
		</div>
	</div>
	<div class="cols content center" id="content">
		!--Content--
	</div>
	<div class="cols drop">&nbsp;</div>
</div>