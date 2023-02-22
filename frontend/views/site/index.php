<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Bazar Ramadan Plats Selangor';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="site-heading display-4">Bazar Ramadan</h1>

        <div class="lead mb-3">
            <img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>" width="200px"/>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{input}"
            ],
        ]); ?>  


        <p class="">SILA MASUKKAN NOMBOR KAD PENGENALAN ANDA</p>
        <br/>

        <?= $form->field($model, 'ic_no', [
            'options'=>[
                'class'=>'',
            ],
            'template'=>'{input}'
            
        ])->textInput([ 'autofocus' => true, 'placeholder'=>'No Kad Pengenalan']) ?>
        <!--<hr class="mt-5" style="border-top: 2px solid #d39e00">-->
        <br/>

        <p align="left" style="font-style: italic;">Contoh: 800323105512</p>

        <p align="left" class="text-sm" style="font-style: italic;">* Hanya peniaga yang mempunyai permit bazar Ramadan dari Pihak Berkuasa Tempatan layak membuka kedai di Bazar Ramandan PLATS.</p>

        <div class="">
        </div>


        <div class="d-flex justify-content-center">
            <!--<a class="btn btn-md btn-success mt-3" href="/">Semak Kelayakan</a>-->
            <?= Html::submitButton('Semak Kelayakan', ['class' => 'btn btn-sm btn-success mt-3', 'style'=>'background: #f37a20; border-color: #f37a20;', 'name' => 'login-button']) ?>
        </div>

        <?= Yii::$app->session->getFlash('success')?>
        <?= Yii::$app->session->getFlash('error')?>

        <?php ActiveForm::end(); ?>

        <div class="d-flex justify-content-center">
            <u class="mt-3">Soalan Lazim</u>
        </div>
        <div class="d-flex justify-content-center">
            <p class="mt-3 text-muted">PLATS adalah sebuah Inisiatif Kerajaan Selangor di bawah</p>
        </div>
        <div class="d-flex justify-content-center">
            <img src="<?=Yii::$app->params['backendUrl'].'/storage/mbi_pnsb_logo@2x.png'?>" width="220px"/>
        </div>
        <div class="d-flex justify-content-center">
            <p class="mt-3 text-muted">dengan kerjasama Pihak Berkuasa Tempatan Selangor</p>
        </div>
        <div class="d-flex justify-content-center d-lg-none">
            <!--<div class="row">-->
            <?php foreach(\common\models\PbtLocation::find()->all() as $location):?>
                <!--<div class="col-sm-4">
                    <img width="30" height="30" src="<?= Yii::$app->params['backendUrl']?>/storage/<?= $location->code?>.png"/>
                </div>-->
            <?php endforeach;?>
            <!--</div>-->
            <?php 
                $items = \common\models\PbtLocation::find()->all();
                $numberOfColumns = 3;
                $bootstrapColWidth = 12 / $numberOfColumns ;
            
                $arrayChunks = array_chunk($items, $numberOfColumns);
                foreach($arrayChunks as $items) {
                    echo '<div class="row">';
                    foreach($items as $item) {
                        echo '<div class="col-lg-12 col-md-'.$bootstrapColWidth.'">';
                        // your item
                        echo '<img width="30" height="30" src="'.Yii::$app->params['backendUrl'].'/storage/'.$item->code.'.png"/>';
                        echo '</div>';
                    }
                    echo '</div>';
                }   
            ?>
            <!--<img src="<?=Yii::$app->params['backendUrl'].'/storage/pbt_logo@2x.png'?>" width="400px"/>-->
        </div>
        <div class="d-none d-lg-block text-center">
            <?php foreach(\common\models\PbtLocation::find()->all() as $location):?>
                    <img width="30" height="30" src="<?= Yii::$app->params['backendUrl']?>/storage/<?= $location->code?>.png"/>
                <!--<div class="col-sm-4">
                    <img width="30" height="30" src="<?= Yii::$app->params['backendUrl']?>/storage/<?= $location->code?>.png"/>
                </div>-->
            <?php endforeach;?>
        </div>
    </div>

</div>
