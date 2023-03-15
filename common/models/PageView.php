<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_view".
 *
 * @property int $id
 * @property int|null $page_id
 * @property string|null $ip_address
 * @property int|null $created_at
 *
 * @property Page $page
 */
class PageView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'created_at'], 'integer'],
            [['ip_address'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'ip_address' => 'Ip Address',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }
}
