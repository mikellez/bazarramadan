<?php

/** @var yii\web\View $this */

$this->title = 'Bazar Ramadan Plats Selangor';
?>
<div class="add-listing-success-page">

    <div class="jumbotron text-center bg-transparent" style="padding: 0 0 0 0;">
		<!--<h1>Logo</h1>-->
		<div class="mb-5">
			<img src="<?= Yii::$app->params['backendUrl']?>/storage/celebrate.png" style="width: 150px"/>
		</div>
		<h2>Kami telah menerima pendaftaran kedai digital anda di Bazar Ramadan PLATS!</h2>
		<h2>Terima Kasih.</h2>
	</div>

	<div class="jumbotron">
		<p>Nota:</p>
		<p>1. Laman web Bazar Ramandan PLATS akan dibuka kepada pelanggan mulai 23 Mac 2023.</p>
		<p>2. Pendaftaran anda akan disemak dan diluluskan oleh pihak PBT bazar anda.</p>
		<p>3. Untuk maklumat lebih lanjut, sila rujuk kepada senarai <u><a href="/site/faq" style="color:black">soalan lazim</a></u></p>
		<p>4. Kalau ingin pulang ke halaman senarai, sila tekan butang <b>Halaman Senarai</b></p>
		<p>5. Kalau pendaftaran sudah dilengkapi, sila tekan butang <b>Tamat</b></p>
	</div>

	<a class="btn btn-sm btn-warning float-left mb-5" href="/dashboard"><i class="fa fa-long-arrow-left"></i> Halaman Senarai</a>
	<a class="btn btn-sm btn-warning float-right mb-5" href="/dashboard">Tamat <i class="fa fa-check"></i></a>
</div>