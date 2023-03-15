<div class="row">
	<?php
		$numberOfColumns = 4;
		$bootstrapColWidth = 12 / $numberOfColumns ;
	
		$arrayChunks = array_chunk($models, $numberOfColumns);
	?>
	<?php foreach($arrayChunks as $items) :?>
		<?php foreach($items as $item):?>
			<div class="col-sm-6 col-md-6 col-lg-<?= $bootstrapColWidth?>">
				<a href="/site/listing-detail?id=<?= $item->id?>">
				<img width="250" src="<?= Yii::$app->params['backendUrl']?>/storage/uploads<?= $item->cover_image?>"/>
				<h4><?= $item->shop_name?></h4>
				<p><?= $item->tagline?></p>
				</a>
			</div>
		<?php endforeach;?>
	<?php endforeach;?>
</div>