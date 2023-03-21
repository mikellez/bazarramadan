<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);

$pbt_location = \common\models\PbtLocation::find()->all();
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

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top position-fixed w-100">
    <a class="navbar-brand" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/index"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <i class="fa fa-navicon" style="color:#fff; font-size:28px;"></i>
        </span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="">
            <li class="nav-item d-lg-none">
                <a class="nav-link" href="https://bazarramadan.platselangor.com">Halaman Utama</a>
            </li>
        </ul>
    </div>
	<a class="text-muted d-none d-lg-block logout" href="https://bazarramadan.platselangor.com">Halaman Utama</a>
</nav>

<div class="container">
	<div class="row">

		<main role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-5 px-4">
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


<footer class="footer mt-auto py-3 text-muted text-center d-none d-lg-block" style="">
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