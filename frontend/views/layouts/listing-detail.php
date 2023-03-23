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
<style>
    main {
        background-image: url(http://localhost:8081/storage/home_bg.jpeg);
        background-position: bottom left;
        background-repeat: no-repeat;
        background-size: cover;
    }

</style>
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
	<a class="navbar-brand" href="/site/index"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
  <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">
        <i class="fa fa-navicon" style="color:#fff; font-size:28px;"></i>
	</span>
  </button>-->

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
  </div>
	<!--<a class="text-muted d-none d-lg-block logout" href="/dashboard/logout">Halaman Utama</a>-->
	<a class="btn btn-sm " style="background-color: #fff; border-radius: 50px; color: #901B1F" href="/dashboard/logout">Daftar Bazar Ramadan</a>
</nav>
</header>

<main role="main" class="flex-shrink-0" style="background: #f4f4f4">
    <div class="container-listing">
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
