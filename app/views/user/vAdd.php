<form method="post" action="Users/update">
<fieldset>
<legend>Ajouter/modifier un utilisateur</legend>
<div class="alert alert-info">Utilisateur : <?php echo $user->toString()?></div>
<div class="form-group">
	<input type="hidden" name="id" value="<?php echo $user->getId()?>">
	<input type="mail" name="mail" value="<?php echo $user->getMail()?>" placeholder="Entrez l'adresse email" class="form-control" <?php echo $disabled?>>
	<input type="text" name="login" value="<?php echo $user->getLogin()?>" placeholder="Entrez un login" class="form-control" <?php echo $disabled?>>
	<input type="password" name="password" value="<?php echo $user->getPassword()?>" placeholder="Entrez le mot de passe" class="form-control" <?php echo $disabled?>>
	<div class="checkbox">
		<label><input type="checkbox" name="admin" <?php echo ($user->getAdmin()?"checked":"")?> value="1">Administrateur ?</label>
	</div>
</div>
<div class="form-group">
	<input type="submit" value="Valider" class="btn btn-default">
	<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>users">Annuler</a>
</div>
</fieldset>
</form>
