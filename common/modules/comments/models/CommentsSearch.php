<?php

namespace common\modules\comments\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\comments\models\Comments;

/**
 * CommentsSearch represents the model behind the search form about `common\modules\comments\models\Comments`.
 */
class CommentsSearch extends Comments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'user_id', 'entity_id', 'created_at'], 'integer'],
            [['model', 'thread', 'name', 'feed_back', 'comment', 'positive', 'negative', 'admin_comment', 'ip'], 'safe'],
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
        $query = Comments::find();

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
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'entity_id' => $this->entity_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'thread', $this->thread])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'feed_back', $this->feed_back])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'positive', $this->positive])
            ->andFilterWhere(['like', 'negative', $this->negative])
            ->andFilterWhere(['like', 'admin_comment', $this->admin_comment])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
