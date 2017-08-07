<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advert;

/**
 * AdvertSearch represents the model behind the search form about `common\models\Advert`.
 */
class AdvertSearch extends Advert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'currency', 'year', 'condition', 'operating_hours', 'mileage'], 'integer'],
            [['title', 'body', 'website', 'manufacture', 'phone', 'model', 'bucket_capacity', 'tire_condition:', 'serial_number', 'created', 'updated', 'published'], 'safe'],
            [['price'], 'number'],
            [['status', 'maderated'], 'boolean'],
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
        $query = Advert::find();

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
            'price' => $this->price,
            'currency' => $this->currency,
            'year' => $this->year,
            'condition' => $this->condition,
            'operating_hours' => $this->operating_hours,
            'mileage' => $this->mileage,
            'created' => $this->created,
            'updated' => $this->updated,
            'published' => $this->published,
            'status' => $this->status,
            'maderated' => $this->maderated,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'manufacture', $this->manufacture])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'bucket_capacity', $this->bucket_capacity])
            ->andFilterWhere(['like', 'tire_condition', $this->tire_condition])
            ->andFilterWhere(['like', 'serial_number', $this->serial_number]);

        return $dataProvider;
    }
}
