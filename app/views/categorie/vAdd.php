<form method="post" action="categories/add">
<fieldset>
<legend>Ajouter une catégorie</legend>
<input type="text" name="libelle" placeholder="Entrez un libelle" class="form-control">
<select class="form-control" name="idCategorie">
<?php echo $select?>
</select>
<input type="submit" value="Valider" class="btn btn-default">
<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>categories">Annuler</a>

</fieldset>
</form>
