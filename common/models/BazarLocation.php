<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bazar_location".
 *
 * @property int $id
 * @property int|null $pbt_location_id
 * @property string $code
 * @property string $name
 *
 * @property Bazar[] $bazars
 * @property PbtLocation $pbtLocation
 */
class BazarLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pbt_location_id'], 'integer'],
            [['code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['pbt_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => PbtLocation::class, 'targetAttribute' => ['pbt_location_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pbt_location_id' => 'Pbt Location ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Bazars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazars()
    {
        return $this->hasMany(Bazar::class, ['bazar_location_id' => 'id']);
    }

    /**
     * Gets query for [[PbtLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPbtLocation()
    {
        return $this->hasOne(PbtLocation::class, ['id' => 'pbt_location_id']);
    }
}
