<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;

/** @var yii\web\View $this */

$this->title = 'Senarai Bazar';

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
        'label'=> 'No IC',
        'attribute'=>'user_id',
        'value'=> 'user.ic_no',
        'headerOptions' => [
            'class'=>'text-center'
        ],
        'contentOptions' => [
            'class'=>'text-center'
        ]
    ],
    [
        'label'=> 'Lokasi PBT',
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
        'label'=> 'Lokasi Bazar',
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
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'checkboxOptions' => function ($model, $key, $index, $column) {
            if (in_array($model->status, [$model::STATUS_APPROVE, $model::STATUS_REJECT])) {
                return ['disabled'=>true];
            }
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'pageSummary' => '<small>(amounts in $)</small>',
        'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl']
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
        <?php echo GridView::widget([
            'id' => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns, // check this value by clicking GRID COLUMNS SETUP button at top of the page
            'headerContainer' => ['style' => '', 'class' => 'kv-table-header'], // offset from top
            'floatHeader' => true, // table header floats when you scroll
            'floatPageSummary' => true, // table page summary floats when you scroll
            'floatFooter' => false, // disable floating of table footer
            'pjax' => false, // pjax is set to always false for this demo
            // parameters from the demo form
            'responsive' => true,
            'responsiveWrap' => false,
            'bordered' => true,
            'striped' => false,
            'condensed' => true,
            'hover' => true,
            'showPageSummary' => false,
            'summary' => "Menunjukkan <b>{begin}</b>-<b>{end}</b> daripada <b>{totalCount}</b> item.",
            'panel' => [
                'after' => '',
                'heading' => '',
                'type' => 'primary',
                'before' => '',
            ],
            // set your toolbar
            'toolbar' =>  [
                [
                    'content' =>
                        Html::button('<i class="fa fa-check"></i> Approve', [
                            'id'=>'approveAll-btn',
                            'class' => 'btn btn-success',
                            'title' => 'Approve',
                            'href' => Url::base().'/site/approveAll'
                            //'onclick' => ''
                        ]) . ' '.
                        Html::button('<i class="fa fa-times"></i> Reject', [
                            'id'=>'rejectAll-btn',
                            'class' => 'btn btn-danger',
                            'title'=>'Reject',
                            'href' => Url::base().'/site/rejectAll',
                            //'data-pjax' => 0, 
                        ]), 
                    'options' => ['class' => 'btn-group mr-2 me-2']
                ],
            ],
            'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
            'persistResize' => false,
            'toggleDataOptions' => ['minCount' => 10],
            'itemLabelSingle' => 'book',
            'itemLabelPlural' => 'books'
        ]);
         
        ?> 
        <!--</div>-->
        <!-- /.card-body -->
    </div>

</div>

<?php 
$url = Yii::getAlias('@web');//Yii::$app->getUrlManager()->getBaseUrl(true);
//->baseUrl;
$js = <<<JS
    $(document).ready(function() {
        $("#approveAll-btn").on("click", function() {
            var keys = $("#kv-grid-demo").yiiGridView("getSelectedRows");
            if(keys.length<=0) {
                alert("No rows selected for approve");
                return;
            }
            $.ajax({
                type: 'POST',
                url: "/admin/site/approve-all",
                data: { 'BazarSearch[id]' : keys.join() },
                traditional: true,
                success: function(data) {
                    if(!data.success) {
                        alert(data.message);
                        return;
                    }
                    alert('Approve successful!');
                    location.reload();
                    //$("#product-grid-container").html(data);
                    //$.pjax.reload({container: '#pjax-product-grid', 'timeout': 5000});
                    //swal("Success..","Your product is added successfull!","success");
                }
            });
        });

        $("#rejectAll-btn").on("click", function() {
            var keys = $("#kv-grid-demo").yiiGridView("getSelectedRows");
            if(keys.length<=0) {
                alert("No rows selected for reject");
                return;
            }
            $.ajax({
                type: 'POST',
                url: "/admin/site/reject-all",
                data: { 'BazarSearch[id]' : keys.join() },
                traditional: true,
                success: function(data) {
                    if(!data.success) {
                        alert(data.message);
                        return;
                    }
                    alert('Reject successful!');
                    location.reload();
                    //$("#product-grid-container").html(data);
                    //$.pjax.reload({container: '#pjax-product-grid', 'timeout': 5000});
                    //swal("Success..","Your product is added successfull!","success");
                }
            });
        });
    })
JS;

$this->registerJs($js, $this::POS_END);
