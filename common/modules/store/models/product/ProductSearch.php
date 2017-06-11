<?php

namespace common\modules\store\models\product;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Model
{
    protected $_model;

    public $id;
    public $cid;
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

    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     *
     * @return ProductInterface
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     *
     * @param ProductInterface $model
     */
    public function setModel(ProductInterface $model)
    {
        $this->_model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'available', 'id', 'cid'], 'integer'],
            [['price', 'old_price'], 'number'],
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
        $query = ProductBase::find();

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
            'cid' => $this->cid,
            'price' => $this->price,
            'sku' => $this->sku,
            'source_id' => $this->source_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
