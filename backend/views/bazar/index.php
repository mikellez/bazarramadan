<?php

use common\models\Bazar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\BazarSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bazars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bazar-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bazar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'shop_name',
            'cover_image:ntext',
            'tagline:ntext',
            //'description:ntext',
            //'tag',
            //'whatsapp_no',
            //'pbt_location_id',
            //'bazar_location_id',
            //'status',
            //'active',
            //'created_at',
            //'updated_at',
            //'click_count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Bazar $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
