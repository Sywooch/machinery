<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdsRegions;

/**
 * AdsRegionsSearch represents the model behind the search form about `backend\models\AdsRegions`.
 */
class AdsRegionsSearch extends AdsRegions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'banner_count'], 'integer'],
            [['name', 'transliteration'], 'safe'],
            [['price_front', 'price_category', 'price_subcategory'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = AdsRegions::find();

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
            'price_front' => $this->price_front,
            'price_category' => $this->price_category,
            'price_subcategory' => $this->price_subcategory,
            'status' => $this->status,
            'banner_count' => $this->banner_count,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'transliteration', $this->transliteration]);

        return $dataProvider;
    }
}
