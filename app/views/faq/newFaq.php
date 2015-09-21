<form name="frmfaq" id="frmfaq" onSubmit="return false;">
	<div class="form-group">
		<label for="titre">Titre : </label>
		<input type="hidden" id="id" name="id" value="">
		<input type="text" class="form-control" id="titre" name="titre" value="">
		<textarea name="description" id="description" placeholder="Entrez la description" class="form-control"><?php echo $ticket->getDescription()?></textarea>
	</div>
	<a class="btn btn-primary" id="btUpdateTitre">Ajouter</a>
	<a href="faqs" class="btn btn-primary" id="btUpdateTitre">Retour</a>
</form>

