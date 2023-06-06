
<!--<div class="order col-sm-12 col-md-12 col-lg-4 mb-5" style="border-radius: 2px; /*width: 250px;*/ height: 250px; position:relative;">
	<a href="/site/listing-detail?id=<?= $model->id?>">
	<div class="lf-overlay"></div>
	<div style="width:100%; height: 100%; background-image: url('<?= Yii::$app->params['backendUrl']?>/storage/uploads<?= $model->cover_image?>'); background-position: 50%; background-size: cover; border-radius:20px;">
		<span class="text-white text-center" style="position: absolute; z-index: 4; top:80%; left:0; right: 0; bottom: 0; text-align:center;"><?= $model->shop_name?></span>
	</div>
	</a>
</div>-->
<div class="order col-sm-12 col-md-12 col-lg-4 mb-5" style="border-radius: 2px; /*width: 250px;*/ height: 334px; position:relative;">
	<a href="/site/listing-detail?id=<?= $model->id?>">
	<div class="lf-overlay"></div>
	<div style="width:100%; height: 100%; background-image: url('<?= Yii::$app->params['backendUrl']?>/storage/uploads<?= $model->cover_image?>'); background-position: center center; background-size: contain; background-repeat: no-repeat; border-radius:20px;">
		<span class="text-white text-center" style="position: absolute; z-index: 4; top:80%; left:0; right: 0; bottom: 0; text-align:center;"><?= $model->shop_name?></span>
	</div>
	</a>
</div>