<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

$this->title = 'Bazar Ramadan Plats Selangor';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="site-heading display-4">
            <img width="300" height="300" src="<?= Yii::$app->params['backendUrl']?>/storage/Logo PLATS Ramadan.png"/>
        </h1>
        <!--<h1 class="site-heading display-4">Bazar Ramadan</h1>-->

        <div class="lead mb-3">
            <img src="<?=Yii::$app->params['backendUrl'].'/storage/platselangor_logo@2x.png'?>" width="200px"/>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'action' => ['site/listing'],
            'method' => 'post',
            'fieldConfig' => [
                'template' => "{input}"
            ],
        ]); ?>  

        <br/>
        <h4 class="text-muted">Cari juadah bazar Ramadan di seluruh Selangor</h4>
        <br/>
        <div class="" style="border-radius: 10px; padding-top: 16px; box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);background-color: #fff;">
        <div class="row">
            <div class="col-lg-4 col-md-12">

                <?= $form->field($model, 'pbt_location_id', [
                    'options'=>[
                        'class'=>'form-group search-field',
                        'value'=>null
                    ],
                    'template'=> '{label}{input}'
                ])
                ->label(false)
                ->widget(Select2::classname(), [
                    'data' => \common\models\Bazar::getPbtLocationList(),
                    'options' => ['placeholder' => 'Seluruh selangor'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ?>
                
            </div>
            <div class="col-lg-4 col-md-12">

                <?= $form->field($model, 'bazar_location_id', [
                    'options'=>[
                        'class'=>'form-group search-field',
                    ],
                    'template'=> '{label}{input}'
                ])
                ->label(false)
                ->widget(DepDrop::classname(), [
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' => [],
                    'options' => ['id' => 'subcat1-id', 'placeholder' => 'Semua bazar'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['searchform-pbt_location_id'],
                        'url' => Url::to(['/add-listing/bazar-location-list']),
                        'params' => ['input-type-1', 'input-type-2']
                    ]
                ]);
                ?>

            </div>
            <div class="col-lg-2 col-md-12">

                <?= $form->field($model, 'text', [
                    'options'=>[
                        'class'=>'search-field',
                    ],
                    'template'=>'
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">&#128269;</span>
                            </div>
                            {input}
                        </div>
                    ',
                    //'enableClientValidation'=>false
                    
                ])
                ->textInput([ 'autofocus' => true, 'placeholder'=>'Jenis juadah...']) ?>
                <!--<hr class="mt-5" style="border-top: 2px solid #d39e00">-->

            </div>
            <div class="col-lg-2 col-md-12">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-sm btn-success', 'style'=>'background: #f37a20; border-color: #f37a20; border-radius: 20px; width: 100px; height: 37px;', 'name' => 'login-button']) ?>

            </div>
        </div>

        


        
        </div>

        <?= Yii::$app->session->getFlash('success')?>
        <?= Yii::$app->session->getFlash('error')?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
