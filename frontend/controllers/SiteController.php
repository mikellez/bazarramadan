<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
//use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;

use frontend\controllers\Controller;
use common\models\SearchForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use common\models\Bazar;
use common\models\search\BazarSearch;
use common\models\Order;
use common\models\OrderDetail;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'faq'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'listing';
        $model = new SearchForm();

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Displays add lisiting.
     *
     * @return mixed
     */
    public function actionAddListing()
    {
        $this->layout = 'empty';
        return $this->render('add-listing');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionFaq() {
        return $this->render('faq');
    }

    public function actionListing() {
        $model = new SearchForm();

        $searchModel = new BazarSearch();

        $filter = new ActiveDataFilter([
            'searchModel' => 'common\models\BazarSearch'
        ]);
        
        $filterCondition = null;
        
        // You may load filters from any source. For example,
        // if you prefer JSON in request body,
        // use Yii::$app->request->getBodyParams() below:
        if ($filter->load(\Yii::$app->request->get())) { 
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }
        
        $query = Bazar::find()
            ->select('bazar.*')
            ->joinWith('bazarTexts')
            ->joinWith('bazarItems')
            ->joinWith('bazarItems.tag0')
            ->groupBy(['bazar.id']);
        
        if(Yii::$app->request->post()) {
            if($model->load(Yii::$app->request->post()) && $model->validate()) {
                $query = $query
                    ->where(['=', 'status', Bazar::STATUS_APPROVE]);

                $textArr = explode(" ", $model->text);

                $search = Yii::$app->request->post('SearchForm');

                if(isset($search['pbt_location_id']) && $search['pbt_location_id'] && $search['pbt_location_id'] != "") {
                    $query = $query->andWhere(['=', 'bazar.pbt_location_id', Yii::$app->request->post('SearchForm')['pbt_location_id']]);
                }
                if(isset($search['bazar_location_id']) && $search['bazar_location_id'] && $search['bazar_location_id'] != "") {
                    $query = $query->andWhere(['=', 'bazar.bazar_location_id', Yii::$app->request->post('SearchForm')['bazar_location_id']]);
                }

                if($textArr[0]) {
                    $query = $query
                        ->andWhere([
                            'or',
                            //['in', 'bazar_text.text', $textArr],
                            //['in', 'bazar_item.tag', $textArr],
                            "MATCH(bazar_text.text) AGAINST ('*".$model->text."*' IN BOOLEAN MODE)",
                            "MATCH(tag.name) AGAINST ('*".$model->text."*' IN BOOLEAN MODE)",
                        ]);
                        //$query = $query->andWhere("MATCH(bazar_text.text) AGAINST ('*".$model->text."*' IN BOOLEAN MODE)");


                }

                /*$query = $query->createCommand()
                    ->getRawSql();
                    var_dump($query);die;*/
            }
        }

        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // returns an array of Post objects
        $models = $dataProvider->getModels();

        $this->layout = 'listing';
        return $this->render('listing', [
            'models' => $models,
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListingDetail($id) {
        $model = Bazar::find()
            ->select('bazar.*')
            ->joinWith('bazarItems')
            ->groupBy(['bazar.id'])
            ->where(['bazar.id'=>$id])
            ->one();

        $this->layout = 'listing';
        return $this->render('listing-detail', [
            'model' => $model
        ]);
    }

    public function actionOrder() {
        $bazar_id = intval(Yii::$app->request->post('bazar_id'));

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $order = Order::find()->where(['bazar_id'=>$bazar_id])->one();
            if(!$order) {
                $order = new Order;
                $order->bazar_id = 1;
                $order->total_order = 1;
            }

            if($order->save()) {
                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->ip_address = $_SERVER['REMOTE_ADDR'];
                $order_detail->created_at = time();
                if($order_detail->save()) {
                    $order->total_order = $order->total_order + 1;
                    $order->save();
                } else {
                   var_dump($order_detail->getErrors());die;
                }
            } else {
                var_dump($order->getErrors());die;
            }

            $transaction->commit();
        } catch (Exception $e) {

            $transaction->rollBack();
            echo 'failed';
        }
    }

    public function actionRepopulateBazarItemText() {
        $bazar = \common\models\Bazar::find()->all();
        $bazarItem = \common\models\BazarItem::find()->all();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach($bazarItem as $item) {
                foreach(explode(' ', $item->name) as $item_name) {
                    $bazarText = new \common\models\BazarText;
                    $bazarText->bazar_id = $item->bazar_id;
                    $bazarText->text = $item_name;
                    $bazarText->save();
                }
            }

            foreach($bazar as $item) {
                foreach(explode(' ', $item->shop_name) as $item_name) {
                    $bazarText = new \common\models\BazarText;
                    $bazarText->bazar_id = $item->id;
                    $bazarText->text = $item_name;
                    $bazarText->save();
                }

                foreach(explode(' ', $item->tagline) as $item_name) {
                    $bazarText = new \common\models\BazarText;
                    $bazarText->bazar_id = $item->id;
                    $bazarText->text = $item_name;
                    $bazarText->save();
                }
            }

            $transaction->commit();

        } catch(Exception $e) {

            $transaction->rollBack();
        }
    }

}
