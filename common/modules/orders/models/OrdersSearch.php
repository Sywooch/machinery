<?php

namespace common\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\orders\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `common\modules\orders\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'count', 'created', 'updated', 'ordered'], 'integer'],
            [['price'], 'number'],
            [['name', 'email', 'phone', 'address', 'comment', 'status'], 'safe'],
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
        $query = Orders::find();

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
            'count' => $this->count,
            'price' => $this->price,
            'created' => $this->created,
            'updated' => $this->updated,
            'ordered' => $this->ordered,
            'status' => !$this->status ? null : array_search($this->status, $this->statuses),
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
