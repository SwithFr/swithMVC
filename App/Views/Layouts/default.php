<?php 
	use Core\Helpers\Html;
	use App\Config\AppConfig;
?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title><?= isset($title_for_layout)?$title_for_layout:AppConfig::$appName; ?></title>

    <!-- Bootstrap core CSS -->
    <?= Html::css("bootstrap"); ?>

    <!-- Custom styles for this template -->
    <?= Html::css("doc"); ?>
    <?= Html::css("markdown"); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
        	<?= Html::link(null,"Accueil",null,['class'=>"blog-nav-item active"]); ?>
    			<?= Html::link("pages/doc","Documentaion",null,['class'=>"blog-nav-item"]); ?>
    			<?= Html::link("pages/download","Téléchargement",null,['class'=>"blog-nav-item"]); ?>
    			<?= Html::link("pages/contact","Contact",null,['class'=>"blog-nav-item"]); ?>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title">Swith Framework</h1>
        <p class="lead blog-description">Le plus simple des frameworks PHP français.</p>
      </div>

      <div class="row">

        

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
         
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">Conventions</a></li>
              <li><a href="#">Les controllers</a></li>
              <li><a href="#">Les models</a></li>
              <li><a href="#">Les views</a></li>
              <li><a href="#">Namespaces</a></li>
              <li><a href="#">Helpers</a></li>
              <li><a href="#">Auhtentification</a></li>
              <li><a href="#">Validation</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Nous contacter</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->
		    <?= $content_for_layout; ?>

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>Blog template built for <?= Html::link("admin/docs/index","ADMIN"); ?> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <?= Html::js("bootstrap.min"); ?>
  <?= Html::js("markdown"); ?>
	<?= Html::js("marked"); ?>
  <script>


  </script>
  </body>
</html>