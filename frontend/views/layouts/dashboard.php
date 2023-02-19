<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\DashboardAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<!--<nav class="navbar navbar-dark navbar-expand-lg sticky-top bg-dark flex-md-nowrap p-0">
  	<a class="navbar-brand col-sm-3 col-md-2 mr-0"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
  	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav px-3 mr-auto" style="flex-direction: row">
			<li class="nav-item text-nowrap">
				<a class="nav-link pl-3" href="/dashboard/logout">Logout</a>
			</li>
		</ul>
	</div>
</nav>-->

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
	<a class="navbar-brand"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!--<a class="navbar-brand" href="#">Navbar</a>-->

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="">
		<li class="nav-item d-lg-none">
			<a class="nav-link" href="/dashboard/logout">Logout</a>
		</li>
    </ul>
	<a class="text-muted d-none d-lg-block" href="/dashboard/logout">Logout</a>
</nav>

<div class="container-fluid">
	<div class="row">
		<!-- start side panel -->
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link" href="#">
					<i class="fa fa-user fa-lg"></i>
					<span class="identity">&nbsp; <?= Yii::$app->user->identity->ic_no?><span> <span class="sr-only">(current)</span>
					</a>
				</li>
				</ul>
			</div>
        </nav>
		<!-- end side panel -->


		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
			<div class="container">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= Alert::widget() ?>
				<?= $content ?>
			</div>
		</main>
	</div>
</div>

<footer class="footer mt-auto py-3 text-muted text-center d-none d-lg-block" style="margin-left: 250px;">
    <div class="container">
        <p class="">&copy; <?= Html::encode(Yii::$app->params['footerUrl']) ?> </p>
    </div>
</footer>

<footer class="footer mt-auto py-3 text-muted text-center d-lg-none d-sm-block" style="">
    <div class="container">
        <p class="">&copy; <?= Html::encode(Yii::$app->params['footerUrl']) ?> </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
