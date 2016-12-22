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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
    /* deprecated
    public function getPrefixes($vocabularyIds = null){
        return (new \yii\db\Query())
            ->select(['prefix', 'id'])
            ->from(TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY) 
            ->indexBy('id') 
            ->filterWhere([
                'id' => $vocabularyIds
            ])    
            ->orderBy(['weight' => SORT_ASC])       
            ->column(); 
    }
    */
    
    
    public function getVocabularies(){
        return self::find()
                ->indexBy('id')
                ->orderBy(['weight' => SORT_ASC])->all(); 
    }
}
