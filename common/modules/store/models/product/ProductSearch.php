<?php
namespace common\modules\store\models\product;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\models\product\ProductInterface;
use common\modules\store\components\StoreUrlRule;

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

    public function __construct($config = array()) {
        parent::__construct($config);
    }
    
    public function setModel(ProductInterface $model){
        $this->_model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'available','id'], 'integer'],
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
        $query = $this->_model->find();

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
    
    /**
     * 
     * @param StoreUrlRule $url
     * @return ActiveDataProvider
     */
    public function searchByUrl(StoreUrlRule $url, $limit){
        $query = $this->_model->find()
                ->with([
                    'terms',
                    'files',
                    'alias',
                    'groupAlias',
                    'wish',
                    'compare'
                ]); 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]); 
        
        if(!$url->main){
            return $dataProvider;
        }

        $query->where(['id' => $this->getIdsByIndex(
                    ArrayHelper::map($url->getTerms([$url->main]),'id','id','vid')
        )]);
        
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
    
    /**
     * 
     * @param array $ids
     * @return mixed
     */
    public function getProductsByIds(array $ids){
        if(empty($ids)){
            return [];
        }
        return  $this->_model->find()->where(['id' => $ids])
                ->with([
                    'terms',
                    'files',
                    'alias',
                    'groupAlias',
                    'wish',
                    'compare'
                ])->all();
    }
    
    /**
     * 
     * @param string|array $groups
     * @return type
     */
    public function getProductIdsByGroup($groups){
        if(empty($groups)){
            return [];
        }
        return (new \yii\db\Query())
                        ->select(['t0.id'])
                        ->from($this->_model->tableName().' as t0')
                        ->where(['group' => $groups])
                        ->distinct()
                        ->column();
    }

}
