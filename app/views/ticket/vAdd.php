<form method="post" action="tickets/update">
<fieldset>
<legend>Ajouter/modifier un ticket</legend>
<div class="form-group">
	<input type="submit" value="Valider" class="btn btn-default">
	<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>tickets">Annuler</a>
</div>
<div class="alert alert-info">Ticket : <?php echo $ticket->toString()?></div>
<div class="form-group">
	<input type="hidden" name="id" value="<?php echo $ticket->getId()?>">
	<label for="type">Type</label>
	<select class="form-control" name="type">
	<?php echo $listType;?>
	</select>
	<label for="idCategorie">Catégorie</label>
	<select class="form-control" name="idCategorie">
	<?php echo $listCat;?>
	</select>
	<label for="titre">Titre</label>
	<input type="text" name="titre" id="titre" value="<?php echo $ticket->getTitre()?>" placeholder="Entrez le titre" class="form-control">
	<label for="description">Description</label>
	<textarea name="description" id="description" placeholder="Entrez la description" class="form-control"><?php echo $ticket->getDescription()?></textarea>
</div>
<div class="form-group">
<input type="hidden" name="id" value="<?php echo $ticket->getId()?>">
	<label>Statut</label>
	<select class="form-control" name="idStatut">
	<?php echo $listStatut;?></select>
	
	<label>Emetteur</label>
	<div class="form-control" disabled><?php echo $ticket->getUser()?></div>
	<label for="dateCreation">Date de création</label>
	<input type="text" name="dateCreation" id="dateCreation" value="<?php echo $ticket->getDateCreation()?>" disabled class="form-control">
	<input type="hidden" name="idStatut" value="<?php echo $ticket->getStatut()->getId()?>">
	<input type="hidden" name="idUser" value="<?php echo $ticket->getUser()->getId()?>">
</div>
<div class="form-group">
	<input type="submit" value="Valider" class="btn btn-default">
	<a class="btn btn-default" href="<?php echo $config["siteUrl"]?>tickets">Annuler</a>
</div>
</fieldset>
</form>
