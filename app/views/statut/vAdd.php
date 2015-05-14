<form method="post" action="statuts/update">
<fieldset>
<legend>Ajouter/modifier un statut</legend>
<div class="alert alert-info">Statut : <?php echo $statut->toString()?></div>
<div class="form-group">
	<input type="hidden" name="id" value="<?php echo $statut->getId()?>">
	<input type="text" name="libelle" value="<?php echo $statut->getLibelle()?>" placeholder="Entrez un libelle" class="form-control">
	<select class="form-control" name="icon">
	<?php echo $select?>
	</select>
		<input type="number" name="ordre" value="<?php echo $statut->getOrdre()?>" placeholder="Entrez un ordre" class="form-control">
</div>
<div class="form-group">
	<input type="submit" value="Valider" class="btn btn-default">
	<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>statuts">Annuler</a>
</div>
</fieldset>
</form>
