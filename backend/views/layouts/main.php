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
    <a class="navbar-brand"><img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="">
            <?php foreach($pbt_location as $location):?>
                <?php if(Yii::$app->user->can('canView'.$location->code)):?>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/index?id=<?= $location->id?>">
                    <?= $location->code?> <span class="sr-only">(current)</span> 
                    </a>
                </li>
                <?php endif;?>
            <?php endforeach;?>
            <li class="nav-item d-lg-none">
                <a class="nav-link" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/logout">Logout</a>
            </li>
        </ul>
    </div>
	<a class="text-muted d-none d-lg-block" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/logout">Logout</a>
</nav>

<div class="container-fluid">
	<div class="row">
		<!-- start side panel -->
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/index"><i class="fa fa-user fa-lg"></i>
                        <span class="identity">&nbsp; <?= Yii::$app->user->identity->username?></span></a>
                    </li>
                <?php foreach($pbt_location as $location):?>
                    <?php if(Yii::$app->user->can('canView'.$location->code)):?>
                    <li class="nav-item nav-item-child">
                        <a class="nav-link <?= $location->id == Yii::$app->request->get('id') ? 'active' : ''?>" href="<?= Yii::$app->getUrlManager()->baseUrl?>/site/index?id=<?= $location->id?>">
                        <i class="fa fa-caret-right"></i> &nbsp;
                        <?= $location->code?> <span class="sr-only">(current)</span> 
                        </a>
                    </li>
                    <?php endif;?>
                <?php endforeach;?>
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