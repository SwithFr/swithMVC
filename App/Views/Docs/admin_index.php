<?php use Core\Helpers\Html; ?>
<div class="col-sm-12 blog-main">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>Titre</th>
				<th>Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($docs as $d): ?>
				<tr>
					<th><?= $d->title; ?></th>
					<td><?= $d->type; ?></td>
					<td>
						<?= Html::link("admin/docs/edit","Editer",['id'=>$d->id],['class'=>'text-primary']); ?>
						/
						<?= Html::link("admin/docs/delete","Supprimer",['id'=>$d->id],['class'=>'text-danger']); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?= Html::link("admin/docs/add","Ajouter une doc",null,['class'=>'btn btn-success']); ?>

	<?php if($nbPages > 1): ?>
		<nav>
		  <ul class="pagination">
		    <?php for($i=1; $i <= $nbPages; $i++): ?>
		    	<li><a href="?paginate=<?= $i; ?>"><?= $i; ?></a></li>
			<?php endfor; ?>
		  </ul>
		</nav>
	<?php endif; ?>
</div>
