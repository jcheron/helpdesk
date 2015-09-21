<form name="frmTitre" id="frmTitre" onSubmit="return false;">
	<div class="form-group">
		<label for="titre">Titre : </label>
		<input type="hidden" id="id" name="id" value="<?=$faq->getId()?>">
		<input type="text" class="form-control" id="titre" name="titre" value="<?=$faq->getTitre()?>">
		<textarea name="description" id="description" placeholder="Entrez la question" class="form-control"><?php echo $faq->getContenu()?></textarea>
	</div>
	<a class="btn btn-primary" id="btUpdateTitre"><?php echo $ajou_modif?></a>
	<a href="faqs" class="btn btn-primary" id="btUpdateTitre">Retour</a>
</form>