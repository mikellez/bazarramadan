<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $bazar_id
 * @property int|null $total_order
 * @property int|null $created_at
 *
 * @property Bazar $bazar
 * @property OrderDetail[] $orderDetails
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bazar_id', 'total_order'], 'integer'],
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
            'total_order' => 'Total Order',
            'created_at' => 'Created At',
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

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::class, ['order_id' => 'id']);
    }
}
