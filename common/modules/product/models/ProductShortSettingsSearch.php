<?php

namespace common\modules\product\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\product\models\ProductShortSettings;

/**
 * ProductShortSettingsSearch represents the model behind the search form about `frontend\modules\product\models\ProductShortSettings`.
 */
class ProductShortSettingsSearch extends ProductShortSettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vocabulary_id'], 'integer'],
            [['title'], 'safe'],
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
        $query = ProductShortSettings::find();

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
            'vocabulary_id' => $this->vocabulary_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
