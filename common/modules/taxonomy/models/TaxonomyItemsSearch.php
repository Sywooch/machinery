<?php

namespace common\modules\taxonomy\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaxonomyItemsSearch represents the model behind the search form about `common\modules\taxonomy\models\TaxonomyItems`.
 */
class TaxonomyItemsSearch extends TaxonomyItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vid', 'pid', 'weight'], 'integer'],
            [['name'], 'safe'],
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
        $query = TaxonomyItems::find();

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
            'vid' => $this->vid,
            'pid' => $this->pid,
            'weight' => $this->weight,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
}
