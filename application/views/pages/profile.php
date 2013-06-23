<div class="header">
<h2>Profil</h2>
</div>
<div>
	<div class="cols drop">
		<div class="cols nav drop">&nbsp;</div>
		<div class="cols nav content right">
		<img src="<?php echo $this->user->getAvatar('url');?>" alt="Avatar">
			<ul class="nav">
				<li><a href="<?php echo base_url('timf/view/config');?>">Einstellungen</a></li>
				<li>Freunde und Bekannte</li>
			</ul>
		</div>
	</div>
	<div class="cols content center" id="content">
		<form action="javascript:update(form.status.value, '#ajax')" name="form" id="form">
			<textarea placeholder="Dein Status" rows="10" cols="100" name="status"></textarea><br>
			<input type="submit">
		</form>
		<a id="toggleform" href="javascript:toggle('#form');">Status erneuern anzeigen/verstecken</a><br>
		<span id="ajax"></span>
		<h3>Last Updates</h3>
		<div class="cols drop">&nbsp;</div>
		<div class="cols content updates">
			<ul class="updates" id="updates">
			<?php
				echo $updates;
			?>
			</ul>
		</div>
		<div class="cols drop">&nbsp;</div>
	</div>
	<div class="cols drop">&nbsp;</div>
</div>
<script type="text/javascript" >
setInterval('lastUpdates("#updates")', 5000);
</script>