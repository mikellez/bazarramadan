<?php foreach($model->bazarImages as $bazarImage):?>
	<img width="250" src="<?= Yii::$app->params['backendUrl']?>/storage/uploads/<?= $bazarImage->path?>"/>
<?php endforeach;?>
<h2><?= $model->shop_name?></h2> <button id="btn-whatsapp_no"><?= $model->whatsapp_no?></button>
<p class="text-muted"><?= $model->tagline?></p>
<p class="text-muted">Lokasi Bazar: <?= $model->bazarLocation->name?></p>
<p class="text-muted">Peniaga berlesen di bawah: <?= $model->pbtLocation->name?></p>
<br/>
<h3>MENU</h3>
<ol>
<?php foreach($model->bazarItems as $key=>$bazarItem):?>
	<li><?= $bazarItem->name?> - <?= $bazarItem->price?></li>
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