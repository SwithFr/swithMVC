<?php $title_for_layout = "test"; ?>


<p>ID : <?= $post->id; ?></p>
<h1>TITRE : <?= $post->title; ?></h1>
<?php echo "Un lien pour ".Core\Helpers\Html::link("posts/test","TEST"); ?>