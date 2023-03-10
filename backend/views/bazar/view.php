<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Bazar $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bazars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bazar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'shop_name',
            'cover_image:ntext',
            'tagline:ntext',
            'description:ntext',
            'tag',
            'whatsapp_no',
            'pbt_location_id',
            'bazar_location_id',
            'status',
            'active',
            'created_at',
            'updated_at',
            'click_count',
        ],
    ]) ?>

</div>
