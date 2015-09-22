<form method="post" action="faqs/update" >

	<div class="form-group">
		<br>
		<label for="titre">Titre : </label>
		<input type="hidden" id="id" name="id" value="<?=$faq->getId()?>">
		<input type="text" class="form-control" id="titre" name="titre" value="<?=$faq->getTitre()?>">
		<br>
		<textarea name="contenu" id="descrption" placeholder="Entrez la question" class="form-control"><?php echo $faq->getContenu()?></textarea>
		<br>
		<select class="form-control" name="idCategorie"><?php echo $listCat;?></select>
	</div>
	<button type="submit" class="btn btn-primary" id="btUpdateTitre"><?php echo $ajou_modif?></button>
	<a href="faqs" class="btn btn-warning" id="btUpdateTitre">Retour</a>
</form>