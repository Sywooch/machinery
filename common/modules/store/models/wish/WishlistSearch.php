<?php

namespace common\modules\store\models\wish;


use Yii;
use yii\base\Object;
use yii\helpers\StringHelper;
use common\models\User;
use common\modules\store\models\wish\Wishlist;
use common\modules\store\models\product\ProductInterface;

class WishlistSearch extends Object
{
    private $_model;
    
    public function __construct(Wishlist $model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    
    /**
     * 
     * @return [] int
     */
    public function getIds(User $user = null, ProductInterface $entity = null){
        return (new \yii\db\Query())
                ->select(['id'])
                ->from($this->_model->tableName())
                ->filterWhere([
                    'user_id' => $user ? $user->id : Yii::$app->user->id,
                    'model' => $entity ? StringHelper::basename($entity::className()) : null
                ])
                ->column();
    }
    

    /**
     * 
     * @return int
     */
    public function getCount(User $user = null, ProductInterface $entity = null){
        return (new \yii\db\Query())->select('COUNT(id)')
                ->from($this->_model::tableName())
                ->filterWhere([
                    'user_id' => $user ? $user->id : Yii::$app->user->id,
                    'model' => $entity ? StringHelper::basename($entity::className()) : null
                ])
                ->count();
    }
    
    /**
     * 
     * @param array int $ids
     * @return Wishlist
     */
    public function getItems(array $ids){
        return $this->_model->findAll($ids);
    }
     
}
