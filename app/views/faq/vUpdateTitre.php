<form name="frmTitre" id="frmTitre" onSubmit="return false;">
	<div class="form-group">
		<label for="titre">Titre : </label>
		<input type="hidden" id="id" name="id" value="<?=$faq->getId()?>">
		<input type="text" class="form-control" id="titre" name="titre" value="<?=$faq->getTitre()?>">
	</div>
	<a class="btn btn-primary" id="btUpdateTitre">Modifier</a>
	<a href="" class="btn btn-primary" id="btUpdateTitre">Retour</a>
</form>