<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Bazar;

/**
 * BazarSearch represents the model behind the search form of `common\models\Bazar`.
 */
class BazarSearch extends Bazar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tag', 'whatsapp_no', 'pbt_location_id', 'bazar_location_id', 'status', 'active', 'created_at', 'updated_at', 'click_count'], 'integer'],
            [['shop_name', 'cover_image', 'tagline', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Bazar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tag' => $this->tag,
            'whatsapp_no' => $this->whatsapp_no,
            'pbt_location_id' => $this->pbt_location_id,
            'bazar_location_id' => $this->bazar_location_id,
            'status' => $this->status,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'click_count' => $this->click_count,
        ]);

        $query->andFilterWhere(['like', 'shop_name', $this->shop_name])
            ->andFilterWhere(['like', 'cover_image', $this->cover_image])
            ->andFilterWhere(['like', 'tagline', $this->tagline])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
