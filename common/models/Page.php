<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $total_views
 *
 * @property PageView[] $pageViews
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_views'], 'integer'],
            [['type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'total_views' => 'Total Views',
        ];
    }

    /**
     * Gets query for [[PageViews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageViews()
    {
        return $this->hasMany(PageView::class, ['page_id' => 'id']);
    }
}
