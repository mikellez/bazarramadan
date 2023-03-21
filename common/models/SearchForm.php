<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Search form
 */
class SearchForm extends Model
{
    public $pbt_location_id;
    public $bazar_location_id;
    public $text;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['text'], 'required'],
            [['text'], 'string'],
        ];
    }

}