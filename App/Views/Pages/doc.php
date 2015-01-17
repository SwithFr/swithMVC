<?php use \Michelf\Markdown; ?>


<div class="col-sm-8 blog-main">
	<?php if(!empty($doc->about)): ?>
		<div class="sidebar-module sidebar-module-inset">
		  <h4>À propos</h4>
		  <p><?= $doc->about; ?></p>
		</div>
	<?php endif; ?>
  
  <div class="blog-post">
    <h2 class="blog-post-title"><?= $doc->title; ?></h2>
    <p class="blog-post-meta"><?= $doc->subtitle; ?></p>

    <?=  Markdown::defaultTransform($doc->content); ?>
  </div>

</div>