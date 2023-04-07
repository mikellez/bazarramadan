<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
?>

<?php $form = ActiveForm::begin([
	'id' => 'search-form',
	'action' => ['site/listing'],
	'method' => 'post',
]); ?>  

<div class="mt-5 mb-5" style="border-radius: 10px; padding-top: 16px; box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);background-color: #fff;">
<div class="row">
	<div class="col-lg-4 col-md-12">

		<?= $form->field($model, 'pbt_location_id', [
			'options'=>[
				'class'=>'form-group search-field',
				'value'=>2
			],
			'template'=> '{label}{input}'
		])
		->label(false)
		->widget(Select2::classname(), [
			'data' => \common\models\Bazar::getPbtLocationDetail(),
			'options' => ['placeholder' => 'Seluruh selangor'],
			'pluginOptions' => [
				'allowClear' => true,
				'cache'=>false
			],
		])

		?>
		<?php echo $model->pbt_location_id;?>
		
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
			'inputOptions'=>[
                'class'=>'form-control text-center'
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
	<div class="col-lg-2 col-md-12 text-center">
	<?= Html::submitButton('Cari', ['class' => 'btn btn-sm btn-success', 'style'=>'background: #f37a20; border-color: #f37a20; border-radius: 20px; width: 100px; height: 37px; margin-bottom: 10px;', 'name' => 'login-button']) ?>

	</div>
</div>





</div>

<?= Yii::$app->session->getFlash('success')?>
<?= Yii::$app->session->getFlash('error')?>

<?php ActiveForm::end(); ?>

<?php

$colsCount = 3;

	echo ListView::widget([
		'options' => ['class' => 'list-view'],
		'dataProvider' => $dataProvider,
		'itemOptions' => ['tag' => false],
		'itemView' => '_list_item',
		'summary' => '',
		'layout' => '{items}{pager}',
		'beforeItem' => function ($model, $key, $index, $widget) use ($colsCount) {
			if ($index % $colsCount === 0) {
				return "<div class='row text-center'>";
			}
		},
		'afterItem' => function ($model, $key, $index, $widget) use ($colsCount) {
			$content = '';
			if (($index > 0) && ($index % $colsCount === $colsCount - 1)) {
				$content .= "</div>";
			}
			return $content;
		},
		'pager' => [
			 'class' => \kop\y2sp\ScrollPager::className(),
			 'item' => '.order',
			 'next' => '.next a',
			 'paginationSelector' => '.list-view .pagination',
			 'triggerText' => Yii::t('app', 'Show more'),
			 'triggerTemplate' => '<div class="col-sm-12 col-md-12"><span class="reveal-btn btn btn-sm btn-outline-primary" style="height: 33px;">{text}</span></div>',
			 'noneLeftText' => '',
			 'noneLeftTemplate' => '',
			 'spinnerSrc' => '',
			 'spinnerTemplate' => '',
			 'linkPager'     => [
				'prevPageCssClass' => 'page-item prev',
				'nextPageCssClass' => 'page-item next',
				'prevPageLabel' => 'prev',
				'nextPageLabel' => 'next',
				'pageCssClass' => 'page-item',
				'linkOptions' => [
					'class'=>'page-link'
				],
				'disabledListItemSubTagOptions'=>['class'=>'page-link']
			 ],
			 'linkPagerOptions'     => [
				  'class' => 'pagination',
			 ],
			 'linkPagerWrapperTemplate' => '<div class="col-sm-12 col-md-12 button-news-more mt-3" style=""><div class="wrapper"><div class="paging">{pager}</div></div></div>',
			 'eventOnPageChange' => 'function() {{{ias}}.hidePagination();}',
			 'eventOnReady' => 'function() {{{ias}}.restorePagination();}',
		],
   ]);
	if ($dataProvider->count % $colsCount !== 0) {
		//echo "</div>";
	}
?>

<!--<div class="row mt-5">
	<?php
		$numberOfColumns = 3;
		$bootstrapColWidth = 12 / $numberOfColumns ;
	
		$arrayChunks = array_chunk($models, $numberOfColumns);
	?>
	<?php foreach($arrayChunks as $items) :?>
		<?php foreach($items as $item):?>
			<div class="col-sm-6 col-md-6 col-lg-<?= $bootstrapColWidth?> mb-5" style="border-radius: 2px; width: 250px; height: 250px; position:relative;">
				<a href="/site/listing-detail?id=<?= $item->id?>">
				<div class="lf-overlay"></div>
				<div style="width:100%; height: 100%; background-image: url('<?= Yii::$app->params['backendUrl']?>/storage/uploads<?= $item->cover_image?>'); background-position: 50%; background-size: cover; border-radius:20px;">
					<span class="text-white text-center" style="position: absolute; z-index: 4; top:80%; left:0; right: 0; bottom: 0; text-align:center;"><?= $item->shop_name?></span>
				</div>
				</a>
			</div>
			<br/>
		<?php endforeach;?>
	<?php endforeach;?>
</div>-->
