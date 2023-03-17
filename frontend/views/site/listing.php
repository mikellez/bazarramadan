<?php
use yii\widgets\ListView;

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
				return "<div class='row'>";
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
			 'triggerTemplate' => '<span class="reveal-btn">{text}</span>',
			 'noneLeftText' => '',
			 'noneLeftTemplate' => '',
			 'spinnerSrc' => '',
			 'spinnerTemplate' => '',
			 'linkPager'     => [
				'prevPageCssClass' => 'page-item prev',
				'nextPageCssClass' => 'page-item next',
				'prevPageLabel' => '<span class="page-link">prev</span>',
				'nextPageLabel' => '<span class="">next</span>',
				'pageCssClass' => 'page-item',
				'linkOptions' => [
					'class'=>'page-link'
				]
			 ],
			 'linkPagerOptions'     => [
				  'class' => 'pagination',
			 ],
			 'linkPagerWrapperTemplate' => '<div class="button-news-more"><div class="wrapper"><div class="paging">{pager}</div></div></div>',
			 'eventOnPageChange' => 'function() {{{ias}}.hidePagination();}',
			 'eventOnReady' => 'function() {{{ias}}.restorePagination();}',
		],
   ]);
	if ($dataProvider->count % $colsCount !== 0) {
		echo "</div>";
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