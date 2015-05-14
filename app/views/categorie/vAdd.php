<form method="post" action="categories/update">
<fieldset>
<legend>Ajouter/modifier une catégorie</legend>
<div class="alert alert-info">Catégorie : <?php echo $categorie->toString()?></div>
<div class="form-group">
	<input type="hidden" name="id" value="<?php echo $categorie->getId()?>">
	<input type="text" name="libelle" value="<?php echo $categorie->getLibelle()?>" placeholder="Entrez un libelle" class="form-control">
	<select class="form-control" name="idCategorie">
	<?php echo $select?>
	</select>
</div>
<div class="form-group">
	<input type="submit" value="Valider" class="btn btn-default">
	<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>categories">Annuler</a>
</div>
</fieldset>
</form>
