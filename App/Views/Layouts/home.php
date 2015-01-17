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
    <?= Html::css("cover"); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><?= Html::link(null,"Accueil"); ?></li>
                  <li><?= Html::link("pages/doc","Documentaion"); ?></li>
                  <li><?= Html::link("pages/download","Téléchargement"); ?></li>
                  <li><?= Html::link("pages/contact","Contact"); ?></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
          	<?php $this->Session->flash(); ?>
            <h1 class="cover-heading">Swith MVC</h1>
            <p class="lead">Le plus simple et le plus sympa des frameworks mvc français</p>
            <p class="lead">
              <a href="#" class="btn btn-lg btn-default">Télécharger</a>
              <a href="#" class="btn btn-lg btn-default">Documentation</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Made by<a href="http://getbootstrap.com">Swith</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?= Html::js("bootstrap.min"); ?>
  </body>
</html>
