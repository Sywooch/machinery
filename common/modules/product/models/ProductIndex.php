<?php

namespace common\modules\product\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\base\Object;

class ProductIndex extends Object
{
    private $_model;


    public function __construct($model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return $this->_model->tableName().'_index'; 
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @param string $field
     */
    public function insert(TaxonomyItems $term, $field){
        Yii::$app->db->createCommand()->insert($this->tableName(), [
           'term_id' => $term->id,
           'vocabulary_id' => $term->vid,
           'entity_id' => $this->_model->id,
           'field' => $field,
        ])->execute();
    }


    public function deleteAll($data){
        $patterm = [];
        $params = [];
        foreach($data as $key => $value){
            $patterm[] = $key.'=:'.$key; 
            $params[':'.$key] = $value;
        }
        $query = Yii::$app->db->createCommand()->delete($this->tableName(), implode(' AND ', $patterm))->bindValues($params)->execute();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(ProductDefault::className(), ['id' => 'entity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(TaxonomyItems::className(), ['id' => 'term_id']);
    }
}
