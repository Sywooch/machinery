<?php

namespace common\modules\taxonomy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;


class TaxonomyVocabularySearch extends TaxonomyVocabulary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
        $query = TaxonomyVocabulary::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
    public function getPrefixes(){
        return (new \yii\db\Query())
            ->select(['prefix', 'id'])
            ->from(TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY) 
            ->indexBy('id')    
            ->column(); 
    }
    
}
