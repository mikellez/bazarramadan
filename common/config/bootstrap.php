<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

$baseUrl = str_replace('/backend/web', '', (new yii\web\Request)->getBaseUrl());
$baseUrl = str_replace('/frontend/web', '', $baseUrl);

Yii::setAlias('@uploadUrl', $baseUrl.'/uploads/');
Yii::setAlias('@uploadPath', realpath(dirname(__FILE__).'/../../uploads/'));
// image file will upload in //root/uploads   folder