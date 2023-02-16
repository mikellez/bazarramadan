<?php
/**
 * @var \yii\db\ActiveRecord $model
 * @var \budyaga\cropper\Widget $widget
 *
 */

use yii\helpers\Html;

?>

<div class="cropper-widget">
    <?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
    <?= Html::hiddenInput('width', $widget->width, ['class' => 'width-input']); ?>
    <?= Html::hiddenInput('height', $widget->height, ['class' => 'height-input']); ?>
    <?= Html::img(
        $model->{$widget->attribute} != ''
            ? $model->{$widget->attribute}
            : $widget->noPhotoImage,
        [
            'style' => 'max-height: ' . $widget->thumbnailHeight . 'px; max-width: ' . $widget->thumbnailWidth . 'px',
            'class' => 'thumbnail',
            'data-no-photo' => $widget->noPhotoImage
        ]
    ); ?>

	<input type="file" name="<?= $widget->options['id']?>" id="upload_image"/>

    <div class="cropper-buttons">
        <button type="button" class="btn btn-sm btn-danger delete-photo" aria-label="<?= Yii::t('cropper', 'DELETE_PHOTO');?>">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <?= Yii::t('cropper', 'DELETE_PHOTO');?>
        </button>
        <button type="button" class="btn btn-sm btn-success crop-photo hidden" aria-label="<?= Yii::t('cropper', 'CROP_PHOTO');?>">
            <span class="glyphicon glyphicon-scissors" aria-hidden="true"></span> <?= Yii::t('cropper', 'CROP_PHOTO');?>
        </button>
        <button type="button" class="btn btn-sm btn-info upload-new-photo hidden" aria-label="<?= Yii::t('cropper', 'UPLOAD_ANOTHER_PHOTO');?>">
            <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> <?= Yii::t('cropper', 'UPLOAD_ANOTHER_PHOTO');?>
        </button>
    </div>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Crop Image Before Upload</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="img-container">
						<div class="row">
							<div class="col-md-8">
								<img src="" id="sample_image" />
								<div class="<?= $widget->options['id']?>-new-photo-area" style="height: <?= $widget->cropAreaHeight; ?>px; width: <?= $widget->cropAreaWidth; ?>px;">
									<div class="cropper-label">
										<span><?= $widget->label;?></span>
									</div>
								</div>
								<div class="progress hidden" style="width: <?= $widget->cropAreaWidth; ?>px;">
									<div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: 0%">
										<span class="sr-only"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="preview"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="crop" class="btn btn-primary">Crop</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>	

</div>


<?php 
$js = <<<JS
	$(document).ready(function(){

		var modal = $('#modal');

		var image = document.getElementById('sample_image');

		var cropper;

		$('#upload_image').change(function(event){
			var files = event.target.files;

			var done = function(url){
				//image.src = url;
				modal.modal('show');
			};

			if(files && files.length > 0)
			{
				reader = new FileReader();
				reader.onload = function(event)
				{
					done(reader.result);
				};
				reader.readAsDataURL(files[0]);
			}
		});


});
JS;

$this->registerJs($js, $this::POS_END);
