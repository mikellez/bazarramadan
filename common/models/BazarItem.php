<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bazar_item".
 *
 * @property int $id
 * @property int|null $bazar_id
 * @property string $name
 * @property float|null $price
 * @property int|null $tag
 *
 * @property Bazar $bazar
 * @property Tag $tag0
 */
class BazarItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bazar_id'], 'integer'],
            [['name','price','tag'], 'required', 'message'=>'{attribute} tidak boleh kosong.'],
            [['name'], 'string'],
            [['price'], 'number'],
            [['bazar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bazar::class, 'targetAttribute' => ['bazar_id' => 'id'], 'message'=>'Anda mesti memilih file.'],
            [['tag'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag' => 'id'], 'message'=>'Anda mesti memilih file.'],
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
            'name' => 'Nama',
            'price' => 'Harga',
            'tag' => 'Kategori',
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
     * Gets query for [[Tag0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag0()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag']);
    }
}
