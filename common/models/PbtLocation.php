<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pbt_location".
 *
 * @property int $id
 * @property string|null $code
 * @property string $name
 *
 * @property BazarLocation[] $bazarLocations
 * @property Bazar[] $bazars
 */
class PbtLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pbt_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[BazarLocations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazarLocations()
    {
        return $this->hasMany(BazarLocation::class, ['pbt_location_id' => 'id']);
    }

    /**
     * Gets query for [[Bazars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBazars()
    {
        return $this->hasMany(Bazar::class, ['pbt_location_id' => 'id']);
    }
}
