<form name="frm2Titre" id="frm2Titre" onSubmit="return false;">
	<div class="form-group">
		<label for="titre"><h4>Titre : </h4></label>
		<p id="titre" name="titre"><?=$faq->getTitre()?></p>
		<label for="contenu"><h4>Contenu : </h4></label>
		<p id="contenu" name="contenu"><?=$faq->getContenu()?></p>
		<label for="dateCrea"><h4>Date de creation : </h4></label>
		<p id="dateCrea" name="dateCrea"><?=$faq->getDateCreation()?></p>
		<label for="categorie"><h4>Categorie : </h4></label>
		<p id="categorie" name="categorie"><?=$faq->getCategorie()?></p>
	</div>
	<a href="faqs" class="btn btn-primary" id="btReadElent">Retour</a>
</form>