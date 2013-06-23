<script type="text/javascript" src="<?php echo $this->config->item('base_url')?>/js/sha1.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url')?>/js/login.js"></script>
<div class="header">
	<h1>Hallo und Willkommen auf timf.</h1>
	<p>
		timf ist ein neues soziales Netzwerk.
	</p>
</div>
<div>
<div class="cols drop">&nbsp;</div>
<div class="cols content center">
	<?php
		if(isset($extra)){
			echo "<p>".$extra."</p>\n";		
		}
		if($this->session->userdata('loggedin')) {
			echo "<p>Logged in:)<br><a href=\"".base_url('timf/view/profile')."\">Profil</a></p>";
		}
		else{
			/*-------------------------------------------------------*/
echo <<< 'EOT'
<h2>Na du :)</h2>
<h3>Anmelden</h3>
<p id='status'></p>
<form method='GET' name='form' action="javascript:login(form.username.value, form.password.value, '#status', '#status');">
<label for="username">Name</label><br>
<input type="text" name="username"><br>
<label for="password">Passwort</label><br>
<input type="password" name="password"><br>
<input type="submit" value="Login">
</form>
<h3>Registrieren</h3>
<p>Coming soon :)<br>
Du willst nicht warten? Frage im <a href='https://joinout.de/forum/viewtopic.php?f=12&t=39&p=82#p82' target="_blank">Forum</a> nach ;)<p>
EOT;
			/*-------------------------------------------------------*/
		}
	?>
</div>
<div class="cols drop">&nbsp;</div>
</div>
<div style="clear:both"></div>