<?php

namespace common\modules\product\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\base\Object;

class ProductIndexPivot extends Object
{
    private $_model;
    
    public function __construct($model, $config = array()) {
        $this->_model = $model;
    }
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return $this->_model->tableName().'_index_pivot'; 
    }
}
