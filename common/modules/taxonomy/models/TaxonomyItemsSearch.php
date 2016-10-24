<?php

namespace common\modules\taxonomy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;

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
    
    /**
     * 
     * @param string $name
     * @param int $vocabularyId
     * @param int $parentId
     * @return []
     */
    public function getItemsByName($name, $vocabularyId = null, $parentId = null){
        return (new \yii\db\Query())
            ->select(['t.id', 't.pid', 't.vid', 't.name', 'v.name as vocabulary'])
            ->from(TaxonomyItems::TABLE_TAXONOMY_ITEMS.' t')
            ->innerJoin(TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY.' v', 't.vid = v.id')
            ->where(['like', 't.name', $name]) 
            ->andFilterWhere(['vid' => $vocabularyId, 'pid' => $parentId])         
            ->indexBy('id')
            //->orderBy(['weight' => SORT_ASC])
            ->all();  
    }
    
    /**
     * 
     * @return []
     */
    public function getTaxonomyItemsByVid($vid){
        return TaxonomyItems::find()->where([
            'vid' => $vid
        ])->orderBy([
            'weight' => SORT_ASC
        ])->all();
    }
    
    /**
     * 
     * @return []
     */
    public function getItemsByVid($vid){
       return (new \yii\db\Query())
                ->select(['id', 'pid', 'vid', 'name', 'transliteration', 'transliteration', 'weight' ])
                ->from(TaxonomyItems::TABLE_TAXONOMY_ITEMS)
                ->where(['vid' => $vid])
                ->orderBy([
                    'weight' => SORT_ASC
                ])
                ->indexBy('id')
                ->all();
    }

    /**
     * 
     * @param int $vid
     * @param array $order
     */
    public function setOrder($vid, array $order){
        
        $models = TaxonomyItems::findAll([
            'vid' => $vid
        ]);

        foreach ($models as $model) {
            if (isset($order[$model->id]['pid']) 
                    && ($order[$model->id]['pid'] != $model->pid 
                            || $order[$model->id]['weight'] != $model->weight)) {
                $model->pid = $order[$model->id]['pid'];
                $model->weight = $order[$model->id]['weight'];
                $model->save();
            }
        } 
    }

}
