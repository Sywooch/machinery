<?php

namespace common\modules\store\models;

use yii\base\Object;
use common\helpers\ModelHelper;
use common\modules\store\models\Compares;
use common\modules\store\models\ProductBase;
use common\modules\store\classes\uus\UUS;

class ComparesSearch extends Object
{
    private $_uus;
    private $_model;


    public function __construct(UUS $uus, Compares $model, $config = array()) {
        $this->_model = $model;
        $this->_uus = $uus;
        parent::__construct($config);
    }
    
    public function getUus(){
        return $this->_uus;
    }

    public function getItem(ProductBase $entity){
        return $this->_model::find()->where([
                'session' => $this->_uus->id,
                'entity_id' => $entity->id,
                'model' => ModelHelper::getModelName($entity)
             ])->One();
    }

    public function getItems(ProductBase $entity = null){
         return $this->_model::find()->filterWhere([
                'session' => $this->_uus->id,
                'model' => $entity ? ModelHelper::getModelName($entity) : null
             ])->All();
    }

    public function getIds(){
        return (new \yii\db\Query())
                ->select('id')
                ->from($this->_model::tableName())
                ->where([
                    'session' => $this->_uus->id
                ])
                ->column();
    }
        
    public function getCount(){
        return (new \yii\db\Query())
                ->select('COUNT(id)')
                ->from($this->_model::tableName())
                ->where([
                    'session' => $this->_uus->id
                ])
                ->count();
    }
}
