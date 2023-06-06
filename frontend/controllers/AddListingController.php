<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
//use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use common\base\Model;
use common\models\LoginForm;
use common\models\Bazar;
use common\models\BazarImage;
use common\models\BazarItem;
use common\models\BazarText;
use common\models\UploadForm;

use frontend\controllers\Controller;

/**
 * Add listing controller
 */
class AddListingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays add listing.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'add-listing';

		$model = new Bazar;
		$modelUploadForm = new UploadForm;
		$modelsBazarItem = [new BazarItem];

		if($model->load(Yii::$app->request->post())) {
			//var_dump($_FILES);die;
			$modelsBazarItem = Model::createMultiple(BazarItem::classname());
            Model::loadMultiple($modelsBazarItem, Yii::$app->request->post());

			$model->user_id = Yii::$app->user->id;
			$model->active = 1;
			$model->status = $model::STATUS_PENDING;
			$model->created_by = Yii::$app->user->id;
			$model->created_at = time();
			$model->updated_by = Yii::$app->user->id;
			$model->updated_at = time();

			$model->cover_imageFile = UploadedFile::getInstance($model, 'cover_imageFile');
			$modelUploadForm->imageFile = UploadedFile::getInstances($modelUploadForm, 'imageFile');

			$transaction = \Yii::$app->db->beginTransaction();

			try {
				if ($flag = $model->save()) {
					foreach(explode(" ",$model->shop_name) as $text) {
						$modelBazarText = new BazarText;
						$modelBazarText->bazar_id = $model->id;
						$modelBazarText->text = $text;
						$modelBazarText->save();
						if (! ($flag = $modelBazarText->save())) {
							$transaction->rollBack();
							var_dump($modelBazarText->getErrors());
							break;
						}
					}

					foreach(explode(" ",$model->tagline) as $text) {
						if(!empty($text)) {
							$modelBazarText = new BazarText;
							$modelBazarText->bazar_id = $model->id;
							$modelBazarText->text = $text;
							$modelBazarText->save();
							if (! ($flag = $modelBazarText->save())) {
								$transaction->rollBack();
								var_dump($modelBazarText->getErrors());
								break;
							}

						}
					}

					if ($modelUploadForm->imageFile) {
						foreach ($modelUploadForm->imageFile as $value) {
							$modelBazarImage = new BazarImage;
							$modelBazarImage->bazar_id = $model->id;
							$basePath =  Yii::getAlias('/'.time().'_'.uniqid().'_'.$value->name);
							$fullPath = Yii::getAlias('@backend/web/storage/uploads'.$basePath);
							$dir = dirname($fullPath);
							if(!FileHelper::createDirectory($dir) | !$value->saveAs($fullPath)) {
								throw new Error('Upload error!');
							}
							$image=Yii::$app->image->load($fullPath);
							$image->save($fullPath, 20);

							$modelBazarImage->path = $basePath;
							if (! ($flag = $modelBazarImage->save())) {
								$transaction->rollBack();
								throw new Error('Upload error!');
								break;
							}

						}
					}

					foreach ($modelsBazarItem as $modelBazarItem) {
						$modelBazarItem->bazar_id = $model->id;
						$modelBazarItem->tag = intval($modelBazarItem->tag);
						if (! ($flag = $modelBazarItem->save())) {
							$transaction->rollBack();
							var_dump($modelBazarItem->getErrors());
							break;
						}

						foreach(explode(" ",$modelBazarItem->name) as $text) {
							$modelBazarText = new BazarText;
							$modelBazarText->bazar_id = $modelBazarItem->bazar_id;
							$modelBazarText->text = $text;
							$modelBazarText->save();
							if (! ($flag = $modelBazarText->save())) {
								$transaction->rollBack();
								var_dump($modelBazarText->getErrors());
								break;
							}
						}
					}
				}

				if ($flag) {
					$transaction->commit();
					return $this->redirect('/add-listing/success-page');
				} else {
					$transaction->rollBack();
					var_dump($model->getErrors());die;
					throw new Exception('Error saving..');
				}
			} catch (Exception $e) {
				$transaction->rollBack();
			}

			return $this->redirect('/add-listing/success-page');


		}

        return $this->render('index', [
			'model'=>$model,
			'modelUploadForm'=>$modelUploadForm,
			'modelsBazarItem'=>(empty($modelsBazarItem)) ? [new Tag] : $modelsBazarItem
		]);
    }

    /**
     * Displays success page
     *
     * @return mixed
     */
    public function actionSuccessPage()
    {
		$this->layout = "info";
        return $this->render('success-page');
    }

	public function actionBazarLocationList() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
	 
				$result = self::getBazarLocationList($cat_id); 
				// the getSubCatList1 function will query the database based on the
				// cat_id, param1, param2 and return an array like below:
				// [
				//    'group1' => [
				//        ['id' => '<sub-cat-id-1>', 'name' => '<sub-cat-name1>'],
				//        ['id' => '<sub-cat_id_2>', 'name' => '<sub-cat-name2>']
				//    ],
				//    'group2' => [
				//        ['id' => '<sub-cat-id-3>', 'name' => '<sub-cat-name3>'], 
				//        ['id' => '<sub-cat-id-4>', 'name' => '<sub-cat-name4>']
				//    ]            
				// ]
				
				
				// the getDefaultSubCat function will query the database
				// and return the default sub cat for the cat_id
				
				return ['output' => $result['out'], 'selected' => $result['selected']];
			}
		}
		return ['output' => '', 'selected' => ''];
	}

	function getBazarLocationList($id) {
		$result = Bazar::getBazarLocationList($id);

		return ['out'=>$result, 'selected'=>$result[0]];

	}

	public function actionUpload() {
		if(isset($_POST["image"]))
		{
			$data = $_POST["image"];

			$image_array_1 = explode(";", $data);

			$image_array_2 = explode(",", $image_array_1[1]);

			$data = base64_decode($image_array_2[1]);

			$imageName = time() . '.png';

			file_put_contents($imageName, $data);

			echo '<img src="'.$imageName.'" class="img-thumbnail" />';

			exit;
		}
	}

}