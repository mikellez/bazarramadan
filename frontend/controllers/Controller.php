<?php
namespace frontend\controllers;

use Yii;
use common\models\Page;
use common\models\PageView;

class Controller extends \yii\web\Controller {

    public function beforeAction($action)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $page = Page::find()->where([
                'name'=>$action->controller->id."/".$action->id,
                'type'=>'frontend'
            ])->one();
            if(!$page) {
                $page = new Page; 
                $page->type = 'frontend';
                $page->name = $action->controller->id."/".$action->id;
                $page->total_views = 1;
            }

            if($page->save()) {
                $page_view = new PageView;
                $page_view->page_id = $page->id;
                $page_view->ip_address = $_SERVER['REMOTE_ADDR'];
                $page_view->created_at = time();

                if($page_view->save()) {
                    $exist_ip_address = Page::find()->select('ip_address')
                        ->joinWith('pageViews')
                        ->where([
                            'page_id'=>$page->id,
                            'name'=>$action->controller->id."/".$action->id,
                            'type'=>'frontend'
                        ])->scalar();

                    if($exist_ip_address != $_SERVER['REMOTE_ADDR']) {
                        $page->total_views = $page->total_views + 1;
                        $page->save();
                    }
                }
            }


            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();

        }
        return parent::beforeAction($action);
    }
}
?>