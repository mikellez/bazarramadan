<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "count".
 *
 * @property int|null $no_of_visits
 * @property int|null $no_of_whatsapp
 */
class Count extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_of_visits', 'no_of_whatsapp'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'no_of_visits' => 'No Of Visits',
            'no_of_whatsapp' => 'No Of Whatsapp',
        ];
    }
}
