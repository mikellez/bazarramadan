<?php 
use yii\bootstrap4\Carousel;

$carousel_item = [];
?>
<style>
.owl-carousel .owl-stage {
	display: flex;
}

.owl-carousel .owl-item {
	height: 250px;
}
.owl-carousel .owl-item img {
	height: 250px;
	object-fit: contain;
}
.lf-overlay {
    position: absolute;
    z-index: 3;
    background-color: #242429;
    opacity: 0.4;
    width: 100%;
    height: 100%;
    border-radius: 20px;
}
</style>

<?php foreach($model->bazarImages as $bazarImage):?>
	<?php
	$carousel_item[] = "
		<div>
		<div class='lf-overlay'></div>
		<img class=''  src='".Yii::$app->params['backendUrl']."/storage/uploads/".$bazarImage->path."'/>
		</div>
	";
	?>
<?php endforeach;?>
<div class="text-center mt-5" style="position:relative;">
	<!--<div 
		class="" 
		style="
			position: absolute;
			background-color: #242429;
			opacity: .4;
			width: 100%;
			height: 100%;
			"
	></div>-->
	<?php 
	/*echo Carousel::widget([
		'items' => $carousel_item,
		'options'=> [
			'style'=>'width:100%; position:relative;'
		]
	]);*/
	?>
	<?php \dominus77\owlcarousel2\WrapCarousel::begin([
    'theme' => \dominus77\owlcarousel2\Carousel::THEME_GREEN, // THEME_DEFAULT, THEME_GREEN
    'tag' => 'div', // container tag name, default div
    //'containerOptions' => [/* ... */], // container html options
    'clientOptions' => [
        'loop' => true,
        'margin' => 10,
        'nav' => true,
		'loop' => false,
		'rewind' => true,
		'autoplay' => true,
        'autoplayTimeout' => 3000,
        'autoplayHoverPause' => true,
        'responsive' => [
            0 => [
                'items' => 1,
            ],
            600 => [
                'items' => 3,
            ],
            1000 => [
                'items' => 5,
            ],
        ],
    ],
	'clientScript' => new \yii\web\JsExpression("
		$('.play').on('click',function(){
			owl.trigger('play.owl.autoplay',[3000])
		})
		$('.stop').on('click',function(){
			owl.trigger('stop.owl.autoplay')
		})
	"),
]); ?>

    <!-- begin Items -->
	<?php foreach($carousel_item as $item):?>
		<?php echo $item;?>
	<?php endforeach;?>
    <!-- end Items -->

<?php \dominus77\owlcarousel2\WrapCarousel::end() ?>
</div>
<div class="d-flex justify-content-between mt-5">
	<h2><?= $model->shop_name?></h2> 
	<button class="pr-3 pl-3 btn-success" id="btn-whatsapp_no" style="border: 1.5px solid rgba(0,0,0,.15); border-radius: 50px;" onclick="window.location.href='https://wa.me/<?= $model->whatsapp_no?>'"><i class="fa fa-whatsapp" ></i>&nbsp;&nbsp;Tempah di Whatsapp</button>
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