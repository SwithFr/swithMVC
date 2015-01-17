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
          	<?= Html::link("pages/index","Accueil",null,['class'=>"blog-nav-item active"]); ?>
			<?= Html::link("pages/doc","Documentaion",null,['class'=>"blog-nav-item"]); ?>
			<?= Html::link("docs/admin_index","ADMIN",null,['class'=>"blog-nav-item"]); ?>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title">Administration</h1>
      </div>

      <div class="row">

	    <?= $content_for_layout; ?>

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>Blog template built for <?= Html::link("admin/docs/index","ADMIN",null,['class'=>"blog-nav-item"]); ?> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
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