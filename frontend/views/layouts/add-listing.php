<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
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

<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light position-fixed w-100" style="z-index: 999;">
	<a class="navbar-brand"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="">
		<li id="form-section-bahagian-depan-kedai-bazar-nav" class="nav-item d-lg-none ">
			<a href="#bahagian-depan-kedai-bazar" class="text-muted">
			<i>
				<span></span>
			</i>BAHAGIAN DEPAN KEDAI BAZAR </a>
		</li>
		<li id="form-section-maklumat-penjaja-bazar-nav" class="nav-item d-lg-none ">
			<a href="#menu-dan-gambar-makanan" class="text-muted">
			<i>
				<span></span>
			</i>MENU &amp; GAMBAR MAKANAN </a>
		</li>
		<li id="form-section-maklumat-lokasi-bazar-ramadan-nav" class="nav-item d-lg-none ">
			<a href="#maklumat-lokasi-bazar-ramadan" class="text-muted">
			<i>
				<span></span>
			</i>MAKLUMAT LOKASI BAZAR RAMADAN </a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/dashboard/logout">Logout</a>
		</li>
    </ul>
  </div>
</nav>
</header>

<main role="main" class="flex-shrink-0" style="background: #f4f4f4">
    <div class="container-add-listing">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3">
    <div class="container">
        <p class="text-center">&copy; <?= Yii::$app->params['footerUrl']?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
