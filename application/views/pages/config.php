<div class="header"><h1>Einstellungen</h1></div>
<div>
	<div class="cols drop">&nbsp;</div>
	<div class="cols content">
	<span id="info"></span>
		<h2>Öffentliches Profil</h2>
		<div id="public">
			<form action="javascript:setConfig('pub', document.public, '#info')" name="public">
				<div class="cols drop config">&nbsp;</div>
				<div class="cols content right config">
					<label for="showProfile">Profil anzeigen?</label><br>
					<label for="showFirstname" class="pub">Vornamen anzeigen?</label><br>
					<label for="firstname" class="pub">Vorname</label><br>
					<label for="showLastname" class="pub">Nachnamen anzeigen?</label><br>
					<label for="firstname" class="pub">Nachname</label><br>
					<label for="showAvatar" class="pub">Avatar anzeigen?</label><br>
					<span class="pub">Du kannst deinen Avatar bei den allgemeine Einstellungen ändern.<br></span>
				</div>
				<div class="cols drop left config">
				<!------>
					<input type="checkbox" name="showProfile" id="showProfile" onclick="$('.pub').toggle();" ><br>
				<!------>
					<span class="pub"><input type="radio" value="false" name="showFirstname" class="pub" id="first_no" onclick="$('#firstname').attr('disabled', '');">Nein&nbsp;
						<input type="radio" value="true" name="showFirstname" class="pub" id="first_yes" onclick="$('#firstname').removeAttr('disabled');">Ja<br></span>
				<!-------->
					<span class="pub"><input type="text" name="firstname" id="firstname" class="pub"><br></span>
				<!-------->
					<span class="pub"><input type="radio" value="false" name="showLastname" class="pub" id="last_no">Nein&nbsp;
						<input type="radio" value="true" name="showLastname" class="pub" id="last_yes" checked="">Ja<br></span>
				<!-------->
					<span class="pub"><input type="text" name="lastname" id="lastname" class="pub"><br></span>
				<!-------->
					<span class="pub"><input type="radio" value="false" name="showAvatar" class="pub" id="avatar_no">Nein&nbsp;
						<input type="radio" value="true" name="showAvatar" class="pub" id="avatar_yes">Ja<br></span>
				<!-------->
				</div>
				<div class="clear"></div>
				<input type="submit">	
			</form>
		</div>
		<h2>Allgemein</h2>
		<div id="general">
			<form name="general" action="javascript:setConfig('gen', document.general, '#info')">
				<div class="cols drop config">&nbsp;</div>
				<div class="cols content right config">
					<label>Avatar:</label><br>
				</div>
				<div class="cols drop left config">
					<input type="text" name="avatar" placeholder="Dein Avatar">
				</div>
				<input type="submit">
			</form>
		</div>
	</div>
	<div class="cols drop">&nbsp;</div>
</div>
<script type="text/javascript" >
init();
</script>