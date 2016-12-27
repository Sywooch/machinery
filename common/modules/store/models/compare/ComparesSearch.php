<?php

namespace common\modules\store\models\compare;

use yii\base\Object;
use common\modules\store\models\compare\Compares;
use common\modules\store\models\product\ProductInterface;
use common\modules\store\classes\uus\UUS;
use yii\helpers\StringHelper;

class ComparesSearch extends Object
{
    private $_uus;
    private $_model;


    public function __construct(UUS $uus, Compares $model, $config = array()) {
        $this->_model = $model;
        $this->_uus = $uus;
        parent::__construct($config);
    }
    
    /**
     * 
     * @return type
     */
    public function getUus(){
        return $this->_uus;
    }

    /**
     * 
     * @param [] int $ids
     * @return [] mixed
     */
    public function getItems(array $ids){
        return $this->_model->findAll($ids);
    }
    
    /**
     * 
     * @return [] int
     */
    public function getIds(ProductInterface $entity = null){
        return (new \yii\db\Query())
                ->select(['id'])
                ->from($this->_model->tableName())
                ->filterWhere([
                    'session' => $this->_uus->id,
                    'entity_id' => $entity ? $entity->id : null,
                    'model' => $entity ? StringHelper::basename($entity::className()) : null
                ])
                ->indexBy('id')
                ->column();
    }
    
    /**
     * 
     * @return int
     */    
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
