<?php
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */

$this->title = 'Bazar Listing';

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        //'label'=>'BRAND NAME',
        'attribute'=>'shop_name',
        'headerOptions' => [
            'class'=>'text-center'
        ],
        'contentOptions' => [
            'class'=>'text-center'
        ]
    ],
    [
        'attribute'=>'cover_image',
        'headerOptions'=>[
            'class'=>'text-center'
        ],
        'contentOptions' => [
            'style'=>'width:100px'
        ],
        'content' => function($model) {
            /**  @var \common\models\Product $model */
            return Html::img($model->getCoverImageUrl(), ['style'=> 'width: 50px']);
        },
    
    ],
    [
        'attribute'=>'tagline',
        'headerOptions' => [
            'class'=>'text-center'
        ],
        'contentOptions' => [
            'class'=>'text-center'
        ]
    ],
    [
        'attribute'=>'whatsapp_no',
        'headerOptions' => [
            'class'=>'text-center'
        ],
        'contentOptions' => [
            'class'=>'text-center'
        ]
    ],
    [
        'label'=> 'PBT',
        'attribute'=> 'pbt_location_id',
        'value'=> 'pbtLocation.code',
        'headerOptions'=>[
            'class'=>'text-center'
        ],
        'contentOptions'=>[
            'class'=>'text-center',
        ]
    ],
    [
        'label'=> 'Location',
        'attribute'=> 'bazar_location_id',
        'value'=> 'bazarLocation.name',
        'headerOptions'=>[
            'class'=>'text-center'
        ],
        'contentOptions'=>[
            'class'=>'text-center',
        ]
    ],
    [
        'attribute' => 'status',
        'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Bazar::getStatusList(), [
            'class' => 'form-control',
            'prompt' => 'All'
        ]),
        'format' => 'orderStatus',
        'headerOptions'=>[
            'class'=>'text-center'
        ],
        'contentOptions'=>[
            'class'=>'text-center'
        ]
    ],
    [
        'attribute'=> 'status_by',
        'value'=> 'statusBy.username',
        'headerOptions'=>[
            'class'=>'text-center',
        ],
        'contentOptions'=>[
            'class'=>'text-center',
        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions'=>[
            'class'=>'text-right'
        ],
        'template' => '
            {approve} {reject} {delete}
        ',
        'buttons'=>[
            'approve' => function($url,$model) { 
                if($model->status == $model::STATUS_PENDING) {
                    return  Html::a('<span class="fa fa-check text-success"></span>', ['approve', 'id'=>$model->id], [
                        'title' => Yii::t('app', 'Approve'),
                        'data-confirm' => 'Are you sure you want to approve bazar for this?',
                    ]);
                } 
            },
            'reject' => function($url,$model) { 
                if($model->status == $model::STATUS_PENDING) {
                    return  Html::a('<span class="fa fa-times text-danger"></span>', ['reject', 'id'=>$model->id], [
                        'title' => Yii::t('app', 'Reject'),
                        'data-confirm' => 'Are you sure you want to reject bazar for this?',
                    ]);
                } 
            },
        ]
    ],
    
    ];
    
    
    $gridColumnsExport = [
    ];
?>
<div class="dashboard-index">

    <div class="jumbotron text-center bg-transparent">
        <!--<a class="btn btn-sm btn-warning float-right" href="/add-listing">Daftar Bazar +</a>-->

        <!--<h1 class="display-4">Bazar Listing</h1>-->

        <div class="text-center">
        <?php if($modelPbtLocation !== null):?>
        <p class="lead"><?= $modelPbtLocation->name?> (<?= $modelPbtLocation->code?>)</p>
        <?php else:?>
        <p class="lead">Semua Senarai PBT</p>
        <?php endif;?>
        </div>

        <!--<div class="card card-outline card-primary">
        <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>-->

        <!-- /.card-header -->
        <!--<div class="card-body p-0">-->
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions'=> ['class'=>'table table-striped table-bordered table-sm table-responsive'],
            'columns' => $gridColumns,
            'pager' => [
                'class' => 'yii\bootstrap4\LinkPager'
            ]

        ]); ?> 
        <!--</div>-->
        <!-- /.card-body -->
    </div>

</div>
