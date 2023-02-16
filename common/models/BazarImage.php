<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bazar_image".
 *
 * @property int $id
 * @property int|null $bazar_id
 * @property string $path
 *
 * @property Bazar $bazar
 */
class BazarImage extends \yii\db\ActiveRecord
{
    public $pathFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bazar_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bazar_id'], 'integer'],
            [['path'], 'required'],
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
            'path' => 'Path',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->path->saveAs('uploads/' . $this->path->baseName . '.' . $this->path->extension);
            return true;
        } else {
            return false;
        }
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
