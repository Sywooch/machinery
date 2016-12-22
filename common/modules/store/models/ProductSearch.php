<?php
namespace common\modules\store\models;

use yii\base\Model;
use yii\db\Expression;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\models\ProductBase;
use yii\data\ActiveDataProvider;

class ProductSearch extends Model
{
    private $_model;
    
    public $id;
    public $group;
    public $sku;
    public $title;
    public $source_id;
    public $available;
    public $price;
    public $old_price;
    public $description;
    public $short;
    public $features;

    public function __construct(ProductBase $model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    
    public function setModel(ProductBase $model){
        $this->_model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'available'], 'integer'],
            [['price','old_price'], 'number'],
            [['description', 'short', 'features'], 'string'],
            [['sku'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 255],
        ];
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
        $query = $this->_model::find();

        // add conditions that should always apply here

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
    
    public function getIdsByIndex(array $index){
        $query = (new \yii\db\Query())
                        ->select(['id'])
                        ->from($this->_model->tableName())
                        ->distinct();
        foreach($index as $values){
            $query->andWhere(['&&', 'index', new Expression('ARRAY['.implode(',', $values).']')]);
        }
        return $query->column();
    }
    
    public function findById(array $ids){
        return  $this->_model
                ->find()
                ->where(['id' => $ids]);
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @param int $limit
     * @return mixed
     */
    public function getMostRatedId(TaxonomyItems $taxonomyItem, $limit = 5){

        return (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where(['&&', 'index', new \yii\db\Expression('ARRAY['.$taxonomyItem->id.']')])
                        ->distinct()
                        ->limit($limit)
                        ->all();
    }

}
