<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use kartik\depdrop\DepDrop;
use wbraganca\dynamicform\DynamicFormWidget;
use dosamigos\croppie\CroppieWidget;


$this->title = 'My Yii Application';
?>
<div class="add-listing-index">


    <div class="add-listing-step" style="opacity: 1;">
        <!-- start i section-->
        <?php $form = ActiveForm::begin([
            'id' => 'add-listing-form',
            'fieldConfig' => [
                'template' => "{input}"
            ],
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>  

        <div class="container text-center" style="padding: 3rem 2rem">
            <a class="btn btn-sm btn-warning float-right" href="/dashboard"><i class="fa fa-long-arrow-left"></i> Back</a>
        </div>

        <div class="card" id="bahagian-depan-kedai-bazar">
            <div class="card-header">
                <i class="fa fa-home"></i> BAHAGIAN DEPAN KEDAI BAZAR
            </div>
            <div class="card-body">
                <?= $form->field($model, 'shop_name', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}{error}'
                ])
                ->label('Nama kedai bazar ramadan anda')
                ->textInput([ 'autofocus' => true, 'placeholder'=>'']) ?>

                <?= $form->field($model, 'tagline', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}<small id="taglineHelp" class="form-text text-muted">Contoh tagline: Nasi lemak original Jalan SS2</small>{input}{error}'
                ])
                ->label('Ayat (tagline) untuk menarik perhatian pelanggan (optional)')
                ->textInput([ 'autofocus' => true, 'placeholder'=>'']) ?>

                <?= $form->field($model, 'cover_imageFile', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}<small id="taglineHelp" class="form-text text-muted">*Tip: Upload gambar makanan atau minuman paling menyelerakan</small>{input}{error}'
                ])
                ->label('Upload gambar menu utama (Cover Image)')
                //->fileInput() 
                ->widget(FileInput::classname(), [
                    'options'=>['accept'=>'image/*'],
                    'pluginOptions' => [
                        'previewFileType' => 'image',
                        'showUpload' => false,
                        'required'=>true,
                        'allowedFileExtensions'=> ["jpg", "png", "jpeg"],
                        'minImageWidth' => 200, 
                        'maxImageWidth' => 200,
                        'minImageHeight' => 200, 
                        'maxImageHeight' => 200, 
                    ]
                ])

                ?>


            </div>
        </div>

        <div class="card mt-5" id="menu-dan-gambar-makanan">
            <div class="card-header">
                <i class="fa fa-list"></i> MENU DAN GAMBAR MAKANAN
            </div>
            <div class="card-body">

                <div id="">

                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        //'limit' => 4, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsBazarItem[0],
                        'formId' => 'add-listing-form',
                        'formFields' => [
                            'name',
                            'price',
                            'tag',
                        ],
                    ]); ?>
                    <div class="card mb-2">
                        <div class="card-header">
                            Senarai Menu Makanan & Minuman
                            <button type="button" class="float-right add-item btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body container-items"><!-- widgetContainer -->
                            <?php foreach ($modelsBazarItem as $index => $modelBazarItem): ?>
                                <div class="item card"><!-- widgetBody -->
                                    <div class="card-header">
                                        <span class="panel-title-address">Menu Makanan & Minuman: <?= ($index + 1) ?></span>
                                        <button type="button" class="float-right remove-item btn btn-danger btn-sm"><i class="fa fa-minus"></i> Remove Item</button>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            // necessary for update action.
                                            if (!$modelBazarItem->isNewRecord) {
                                                echo Html::activeHiddenInput($modelBazarItem, "[{$index}]id");
                                            }
                                        ?>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($modelBazarItem, "[{$index}]name", [
                                                    'template'=>'{label}{input}{error}'
                                                    ])
                                                    ->label("Nama")->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($modelBazarItem, "[{$index}]price", [
                                                    'template'=>'{label}{input}{error}'
                                                    ])
                                                    ->label("Harga")->textInput(['maxlength' => true]) ?>
                                            </div>

                                            <div class="col-sm-4">
                                                <?= $form->field($modelBazarItem, "[{$index}]tag", [
                                                    'options'=>[
                                                        //'class'=>'form-group',
                                                    ],
                                                    'template'=> '{label}{input}{error}'
                                                ])
                                                ->label('Tag')
                                                ->widget(Select2::classname(), [
                                                    'data' => [
                                                        1 => "burger",
                                                        2 => "nasi lemak",
                                                    ],
                                                    'options' => ['placeholder' => 'Select an option'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                    'pluginLoading'=> false
                                                ])
                                                ?>
                                            </div>
                                        </div><!-- end:row -->

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php DynamicFormWidget::end(); ?>

                </div>


                <?/*= $form->field($model, 'description', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}'
                ])
                ->label('Senarai menu makanan & minuman')
                ->textInput([ 'autofocus' => true, 'placeholder'=>'']) */?>

                <?= $form->field($modelUploadForm, 'imageFile', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}<small id="taglineHelp" class="form-text text-muted">Maximum file size: 2 MB. Up to 5 files allowed.</small>{error}'
                ])
                ->label('Galeri gambar (Maximum 5 gambar)')
                //->fileInput() 
                ->widget(FileInput::classname(), [
                    'options' => ['multiple' => true, 'accept' => 'image/*'],
                    'pluginOptions' => [
                        'previewFileType' => 'image', 
                        'maxFileCount'=>5, 
                        'maxFileSize'=>2800,
                        'minImageWidth' => 200, 
                        'maxImageWidth' => 200,
                        'minImageHeight' => 200, 
                        'maxImageHeight' => 200, 
                        'showUpload' => false,
                        'required'=>true,
                        'allowedFileExtensions'=> ["jpg", "png", "jpeg"]
                    ],
                ]);
                CroppieWidget::widget(['id' => 'test-widget', 'clientOptions' => ['enableExif']]);
                /*echo $form->field($modelUploadForm, 'imageFile', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> "{label}<div id='uploaded_image'></div>\n\n{input}<small id='taglineHelp' class='form-text text-muted'>Maximum file size: 2 MB. Up to 5 files allowed.</small>{error}"
                ])
                ->label('Galeri gambar (Maximum 5 gambar)')
                ->fileInput();*/
                ?>

                <?= $form->field($model, 'whatsapp_no', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}<small id="mobileNoHelp" class="form-text text-muted">Contoh: 0123456789</small>{error}'
                ])
                ->label('Nombor Telefon (whatsapp) untuk pelanggan membuat tempahan')
                ->textInput([ 'autofocus' => true, 'placeholder'=>'']) ?>

            </div>
        </div>

        <div class="card mt-5" id="maklumat-lokasi-bazar-ramadan">
            <div class="card-header">
                <i class="fa fa-location-arrow"></i> MAKLUMAT LOKASI BAZAR RAMADAN
            </div>
            <div class="card-body">
                <?= $form->field($model, 'pbt_location_id', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}{error}'
                ])
                ->label('Berdaftar di bawah PBT')
                ->widget(Select2::classname(), [
                    'data' => $model::getPbtLocationList(),
                    'options' => ['placeholder' => 'Select an option'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ?>
                <?= $form->field($model, 'bazar_location_id', [
                    'options'=>[
                        'class'=>'form-group',
                    ],
                    'template'=> '{label}{input}{error}'
                ])
                ->label('Lokasi Bazar Ramadan')
                ->widget(DepDrop::classname(), [
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' => [],
                    'options' => ['id' => 'subcat1-id', 'placeholder' => 'Select ...'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['bazar-pbt_location_id'],
                        'url' => Url::to(['/add-listing/bazar-location-list']),
                        'params' => ['input-type-1', 'input-type-2']
                    ]
                ]);
                ?>
            </div>
        </div>

        <div class="text-center">
            <a href="#" class="btn btn-light w-100 mt-5" style="height: 46px;" onclick="resetButton()">Reset</a>
        </div>
        <div class="text-center mb-5">
            <?= Html::submitButton('Submit Listing', ['class' => 'btn btn-md btn-primary mt-3 w-100', 'style'=>'background: #892920; border-color: #892920; height: 46px;', 'name' => 'add-listing-submit-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <!-- end i section --> 

        <div class="add-listing-nav d-none d-lg-block">
            <ul>
            <li id="form-section-bahagian-depan-kedai-bazar-nav">
                <a href="#bahagian-depan-kedai-bazar">
                <i>
                    <span></span>
                </i>BAHAGIAN DEPAN KEDAI BAZAR </a>
            </li>
            <li id="form-section-maklumat-penjaja-bazar-nav" class="">
                <a href="#menu-dan-gambar-makanan">
                <i>
                    <span></span>
                </i>MENU &amp; GAMBAR MAKANAN </a>
            </li>
            <li id="form-section-maklumat-lokasi-bazar-ramadan-nav" class="">
                <a href="#maklumat-lokasi-bazar-ramadan">
                <i>
                    <span></span>
                </i>MAKLUMAT LOKASI BAZAR RAMADAN </a>
            </li>
            </ul>
        </div>

    </div>

</div>

<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image_demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="uploadcoverimageModal">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="cover_image_demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_cover_image">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php 
$js = <<<JS
    function resetButton() {
        document.getElementById("add-listing-form").reset();
    }    

    jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
            jQuery(this).html("Menu Makanan & Minuman: " + (index + 1))
        });
    });

    jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
        jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
            jQuery(this).html("Menu Makanan & Minuman: " + (index + 1))
        });
    });

    window.onunload = function(){}; 

    $(document).ready(function(){
        let systemClick = false;

        resetButton();

        //$("#uploadform-imagefile").fileinput({'showUpload':false, 'previewFileType':'any'});
        $('#bazar-cover_imagefile').on('change', function(){
            if(systemClick == true) {
                systemClick = false;
                return;
            }
            let files = this.files;

            Object.keys(files).forEach(i => {
                $('#crop_coverimage_container'+i).croppie('destroy');

                let div = document.createElement("div");
                div.id = "crop_coverimage_container"+i;
                $('#cover_image_demo').append(div);

                var reader = new FileReader();
                reader.onload = function (event) {
                    $('#crop_coverimage_container'+i).croppie({
                        enableExif: true,
                        viewport: {
                            width:200,
                            height:200,
                            type:'square' //circle
                        },
                        boundary:{
                            width:300,
                            height:300
                        }
                    });

                    $('#crop_coverimage_container'+i).croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[i]);
            });
            $('#uploadcoverimageModal').modal('show');
        });

        $('.crop_cover_image').click(function(event){
            const dataTransfer = new DataTransfer();
            $( "#cover_image_demo .croppie-container" ).each(function( index ) {
                $(this).croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    console.log(response);
                    let image_array1 = response.split(';')[0];
                    let extensionAll = image_array1.split(':')[1];
                    let extension = extensionAll.split('/')[1];

                    const url = response;
                    fetch(url)
                    .then(res => res.blob())
                    .then(blob => {
                        console.log(extension)
                        const file = new File([blob], "image_"+Date.now()+'.'+extension,{ type: extensionAll })
                        /*const file = new File(['Hello World!'], 'myFile.txt', {
                            type: 'text/plain',
                            lastModified: new Date(),
                        });*/
                        /*const dT = new DataTransfer();
                        dT.items.add(new File(['foo'], 'programmatically_created.txt'));
                        document.getElementById('uploadform-imagefile').files = dT.files;*/

                        const fileInput = document.getElementById('bazar-cover_imagefile');
                        //const fileInput = document.querySelector('input[type="file"]');

                        systemClick = true;
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;
                        console.log(fileInput.files);
                        fileInput.dispatchEvent(new Event("change", { "bubbles": true }));
                        console.log(file, fileInput, fileInput.files)
                        $('#uploadcoverimageModal').modal('hide');
                    })
                    /*$.ajax({
                    url:"/add-listing/upload",
                    type: "POST",
                    data:{"image": response},
                    success:function(data)
                    {
                        $('#uploadimageModal').modal('hide');
                        $('#uploaded_image').html(data);
                    }
                    });*/
                })
            });
        });

        $('#uploadform-imagefile').on('change', function(){
            if(systemClick == true) {
                systemClick = false;
                return;
            }
            let files = this.files;

            Object.keys(files).forEach(i => {
                $('#crop_container'+i).croppie('destroy');

                let div = document.createElement("div");
                div.id = "crop_container"+i;
                $('#image_demo').append(div);

                var reader = new FileReader();
                reader.onload = function (event) {
                    $('#crop_container'+i).croppie({
                        enableExif: true,
                        viewport: {
                            width:200,
                            height:200,
                            type:'square' //circle
                        },
                        boundary:{
                            width:300,
                            height:300
                        }
                    });

                    $('#crop_container'+i).croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[i]);
            });
            $('#uploadimageModal').modal('show');
        });

        async function getFile(e) {
            let url = await getCroppieResult(e);
            let image_array1 = url.split(';')[0];
            let extensionAll = image_array1.split(':')[1];
            let extension = extensionAll.split('/')[1];

            return new Promise((resolve)=> {
                fetch(url)
                .then(res => res.blob())
                .then(blob => {
                    console.log(extension)
                    const file = new File([blob], "image_"+Date.now()+'.'+extension,{ type: extensionAll })
                    
                    return resolve(file);

                })

            })
        }

        async function getCroppieResult(e) {
            return new Promise((resolve)=> {
                $(e).croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    console.log(response);

                    return resolve(response);
                })

            })
        }

        async function getFiles() {
            const files = await Promise.all($( "#image_demo .croppie-container" ).map(async function( index ) {
                return await getFile(this);
            }));

            return files;
        }

        $('.crop_image').click(async function(event){
            const dataTransfer = new DataTransfer();
            const fileInput = document.getElementById('uploadform-imagefile');
            let file=[];
            
            systemClick = true;
            files = await getFiles();

            for(let i=0;i<files.length;i++)
                dataTransfer.items.add(files[i]);

            fileInput.files = dataTransfer.files;
            fileInput.dispatchEvent(new Event("change", { "bubbles": true }));

            $('#uploadimageModal').modal('hide');

            console.log(fileInput.files);
            console.log(file, fileInput, fileInput.files)
        });

        $("[href^='#']").click(function() {
            id=$(this).attr("href")
            $('html, body').animate({
                scrollTop: $(id).offset().top
            }, 500);
        });

        /*$(window).scroll(function() {    
            var scroll = $(window).scrollTop();
            var objectSelect = $("#bahagian-depan-kedai-bazar");
            var objectPosition = objectSelect.offset().top;
            var objectPositionHeight = objectSelect.height();
            var objectOffset = 100;
            if (scroll >= (objectPosition - objectOffset) && scroll <= (objectPositionHeight + objectPosition)) {
                $(".add-listing-nav li#form-section-bahagian-depan-kedai-bazar-nav").addClass("active");
            } else {
                $(".add-listing-nav li#form-section-bahagian-depan-kedai-bazar-nav").removeClass("active");
            }

            var objectSelect = $("#menu-dan-gambar-makanan");
            var objectPosition = objectSelect.offset().top;
            var objectPositionHeight = objectSelect.height();
            if (scroll >= (objectPosition + objectOffset) && scroll <= (objectPositionHeight + objectPosition)) {
                $(".add-listing-nav li#form-section-maklumat-penjaja-bazar-nav").addClass("active");
            } else {
                $(".add-listing-nav li#form-section-maklumat-penjaja-bazar-nav").removeClass("active");
            }

            var objectSelect = $("#maklumat-lokasi-bazar-ramadan");
            var objectPosition = objectSelect.offset().top;
            var objectPositionHeight = objectSelect.height();
            if (scroll >= (objectPosition + objectOffset) && scroll <= (objectPositionHeight + objectPosition)) {
                $(".add-listing-nav li#form-section-maklumat-lokasi-bazar-ramadan-nav").addClass("active");
            } else {
                $(".add-listing-nav li#form-section-maklumat-lokasi-bazar-ramadan-nav").removeClass("active");
            }
        });*/

    });  

JS;

$this->registerJs($js, $this::POS_END);
