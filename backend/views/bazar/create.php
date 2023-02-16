<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Bazar $model */

$this->title = 'Create Bazar';
$this->params['breadcrumbs'][] = ['label' => 'Bazars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bazar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
