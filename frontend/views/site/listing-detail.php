<?php 
use yii\bootstrap4\Carousel;

$carousel_item = [];
?>

<?php foreach($model->bazarImages as $bazarImage):?>
	<?php
	$carousel_item[] = "<img class='' width='350' src='".Yii::$app->params['backendUrl']."/storage/uploads/".$bazarImage->path."'/>";
	?>
<?php endforeach;?>
<div class="text-center mt-5" style="position:relative;">
	<div 
		class="" 
		style="
			position: absolute;
			background-color: #242429;
			opacity: .4;
			width: 100%;
			height: 100%;
			"
	></div>
	<?php 
	echo Carousel::widget([
		'items' => $carousel_item,
		'options'=> [
			'style'=>'width:100%; position:relative;'
		]
	]);
	?>
</div>
<div class="d-flex justify-content-between mt-5">
	<h2><?= $model->shop_name?></h2> 
	<button class="pr-3 pl-3" id="btn-whatsapp_no" style="border: 1.5px solid rgba(0,0,0,.15); border-radius: 50px;" onclick="window.location.href='https://wa.me/<?= $model->whatsapp_no?>'"><i class="fa fa-whatsapp" ></i>&nbsp;&nbsp;Tempah di Whatsapp</button>
</div>
<p class="text-muted"><?= $model->tagline?></p>
<table class="mt-5 mb-5">
	<tr>
		<td><i class="fa fa-map-marker text-danger"></i></td>
		<td><span class="text-muted">Lokasi Bazar: <?= $model->bazarLocation->name?></span></td>
	</tr>
	<tr>
		<td><i class="fa fa-check text-success"></i></td>
		<td><span class="text-muted">Peniaga berlesen di bawah: <?= $model->pbtLocation->name?></span></td>
	</tr>
</table>
<h3>MENU</h3>
<ol class="mb-5">
<?php foreach($model->bazarItems as $key=>$bazarItem):?>
	<li><?= $bazarItem->name?> - RM <?= number_format($bazarItem->price,2)?></li>
<?php endforeach;?>
</ol>

<?php 
$bazar_id = $model->id;
$js = <<<JS
	$("#btn-whatsapp_no").on("click", function() {
		$.ajax({
		url:"/site/order",
		type: "POST",
		data:{"bazar_id": $bazar_id},
		success:function(data)
		{
		}
		});
	});
JS;

$this->registerJs($js, $this::POS_END);
?>