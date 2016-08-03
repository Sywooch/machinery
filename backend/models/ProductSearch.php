<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\import\components\Insert;
use common\modules\import\components\Reindex;

/**
 * ProductDefaultSearch represents the model behind the search.
 */
class ProductSearch extends Model
{   
    public $id;
    public $user_id;
    public $source_id;
    public $available;
    public $price;
    public $publish;
    public $sku;
    public $title;
    public $short;
    public $description;
    public $index;
    
    protected $_model;
    protected $_indexModel;

    public function __construct($model) {
        $this->_model = $model;
        $this->_indexModel = $model->className() . 'Index';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'user_id', 'available', 'price'], 'integer'],
            [['sku', 'title', 'short', 'description', 'index'], 'safe'],
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
    
    public function getModel(){
        return $this->_model;
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
        $query = $this->_model->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'source_id' => $this->source_id,
            'user_id' => $this->user_id,
            'available' => $this->available,
            'price' => $this->price,
            'publish' => $this->publish
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'short', $this->short])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
    
    
    /**
     * 
     * @param array $status
     * @param int $limit
     * @return array
     */
    public function getReindexItems(array $status, $limit){
        $model = $this->_model;

        return (new \yii\db\Query())
                        ->select('
                            id,
                            group,
                            model,
                            source_id,
                            user_id,
                            sku,
                            available,
                            price,
                            rating,
                            publish,
                            `reindex` + 0 as reindex,
                            crc32,
                            crc32_reindex,
                            title,
                            description,
                            data'
                        )
                        ->from($model::tableName())
                        ->where(['reindex' => $status])
                        ->limit($limit)
                        ->all();
    }
    
    /**
     * 
     * @param int $status
     * @param [] $ids
     */
    public function setReindexStatus($status, $ids){
        $model = $this->_model;
        Yii::$app->db->createCommand("UPDATE ".$model::tableName()." SET reindex={$status}, crc32_reindex=crc32 WHERE id IN (".implode(',', $ids).")")->execute();
    }

}
