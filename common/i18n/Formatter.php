<?php
namespace common\i18n;

class Formatter extends \yii\i18n\Formatter {
	public function asOrderStatus($status) {
		if($status == \common\models\Bazar::STATUS_APPROVE) {
			return \yii\bootstrap4\Html::tag('span', 'Approved', ['class' => 'badge badge-success']);
		} else if($status == \common\models\Bazar::STATUS_PENDING) {
			return \yii\bootstrap4\Html::tag('span', 'Pending', ['class' => 'badge badge-info']);
		} else if($status == \common\models\Bazar::STATUS_REJECT) {
			return \yii\bootstrap4\Html::tag('span', 'Reject', ['class' => 'badge badge-danger']);
		}	
	}
}
?>