<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;

use backend\models\LoginForm;
use common\models\search\BazarSearch;
use common\models\Bazar;
use common\models\PbtLocation;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'approve', 'reject', 'approveAll', 'rejectAll'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
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
        ];
    }

    public function actionApprove($id) {
        $model = Bazar::findOne($id);
        $model->status = $model::STATUS_APPROVE;
        $model->status_by = Yii::$app->user->id;
        $model->status_at = time();
        $model->save();

        Yii::$app->session->setFlash('success', '
            <div class="mt-3 alert alert-success" role="alert">
                <p><b>Approved!</b> Bazar is approve for '.$model->shop_name.'!</p>
            </div>
            ');

		/*$searchModel = new BazarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        $dataProvider->setPagination(['pageSize' => 10]);
		$dataProvider->query->andWhere(['=', 'active', 1]);*/

        $this->redirect('index');

        /*return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }
    
    public function actionApproveAll() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $searchModel = new BazarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $models = $dataProvider->getModels();

        foreach($models as $model) {
            $model->status = $model::STATUS_APPROVE;
            $model->status_by = Yii::$app->user->id;
            $model->status_at = time();
            $model->save();
        }

        return [ 'message'=>'', 'success'=>true ];
    }

    public function actionReject($id) {
        $model = Bazar::findOne($id);
        $model->status = $model::STATUS_REJECT;
        $model->status_by = Yii::$app->user->id;
        $model->status_at = time();
        $model->save();

		$searchModel = new BazarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        $dataProvider->setPagination(['pageSize' => 10]);
		$dataProvider->query->andWhere(['=', 'active', 1]);

        Yii::$app->session->setFlash('success', '
            <div class="mt-3 alert alert-danger" role="alert">
                <p><b>Rejected!</b> Bazar is rejected for '.$model->shop_name.'!</p>
            </div>
            ');

        $this->redirect('index');

        /*return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/

    }

    public function actionRejectAll() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $searchModel = new BazarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $models = $dataProvider->getModels();

        foreach($models as $model) {
            $model->status = $model::STATUS_REJECT;
            $model->status_by = Yii::$app->user->id;
            $model->status_at = time();
            $model->save();
        }

        return [ 'message'=>'', 'success'=>true ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');

        $modelPbtLocation = NULL;
        if($id>0) {
            $modelPbtLocation = PbtLocation::findOne($id);
            if(!Yii::$app->user->can('canView'.$modelPbtLocation->code))
                throw new ForbiddenHttpException('You are not authorized to access this page.');
        }

		$searchModel = new BazarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort->defaultOrder = ['updated_at' => SORT_DESC];
        $dataProvider->setPagination(['pageSize' => 10]);
		$dataProvider->query->andWhere(['=', 'active', 1]);

        if($id>0) {
		    $dataProvider->query->andWhere(['=', 'pbt_location_id', $id]);
        }

        if(!Yii::$app->user->can('superAdmin') && $id == null) {
            $modelPbtLocation = PbtLocation::findOne(Yii::$app->user->identity->pbt_location_id);
		    $dataProvider->query->andWhere(['=', 'pbt_location_id', $modelPbtLocation->id]);
        }

        return $this->render('index', [
            'modelPbtLocation'=>$modelPbtLocation,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
