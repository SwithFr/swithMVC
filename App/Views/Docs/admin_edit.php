<?php use Core\Helpers\Form; ?>
<h1>Ajouter une documentation</h1>


<div class="col-sm-12 blog-main">
	<?= Form::start("docs/admin_goEdit/".$doc->id); ?>
		<div class="form-group">
			<?= Form::input('text','title','Titre',['class'=>'form-control'],$doc->title); ?>
		</div>
		<div class="form-group">
			<?= Form::input('text','subtitle','Sous-titre',['class'=>'form-control'],$doc->subtitle); ?>
		</div>
		<div class="form-group">
			<label for="about">À propos</label>
			<?= Form::textarea('about',['class'=>'form-control md'],$doc->about); ?>
		</div>
		<div class="form-group">
			<?= Form::input('text','type','Type',['class'=>'form-control'],$doc->type); ?>
		</div>
		<div class="form-group">
			<label for="type">Contenu</label>
			<?= Form::textarea('content',['class'=>'form-control','rows'=>10,'data-provide'=>'markdown'],$doc->content); ?>
		</div>
	<?= Form::end("Ajouter",['class'=>'btn btn-primary']); ?>
</div>