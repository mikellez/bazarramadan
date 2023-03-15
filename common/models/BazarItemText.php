<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bazar_item_text".
 *
 * @property int $id
 * @property int|null $bazar_item_id
 * @property string $text
 *
 * @property BazarItem $bazarItem
 */
class BazarItemText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar_item_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bazar_item_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['bazar_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => BazarItem::class, 'targetAttribute' => ['bazar_item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bazar_item_id' => 'Bazar Item ID',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[BazarItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazarItem()
    {
        return $this->hasOne(BazarItem::class, ['id' => 'bazar_item_id']);
    }
}
