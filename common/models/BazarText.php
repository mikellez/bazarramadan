<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bazar_text".
 *
 * @property int $id
 * @property int|null $bazar_id
 * @property string $text
 *
 * @property Bazar $bazar
 */
class BazarText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bazar_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['bazar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bazar::class, 'targetAttribute' => ['bazar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bazar_id' => 'Bazar ID',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[Bazar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazar()
    {
        return $this->hasOne(Bazar::class, ['id' => 'bazar_id']);
    }
}
