<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\BazarSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bazar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'shop_name') ?>

    <?= $form->field($model, 'cover_image') ?>

    <?= $form->field($model, 'tagline') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'whatsapp_no') ?>

    <?php // echo $form->field($model, 'pbt_location_id') ?>

    <?php // echo $form->field($model, 'bazar_location_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'click_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
