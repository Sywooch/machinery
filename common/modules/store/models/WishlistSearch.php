<?php

namespace common\modules\store\models;


use Yii;
use yii\base\Object;
use common\helpers\ModelHelper;
use common\modules\store\models\Wishlist;
use dektrium\user\models\User;
use common\modules\store\models\ProductBase;

class WishlistSearch extends Object
{
    private $_model;
    
    public function __construct(Wishlist $model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    
    public function getItem(ProductBase $entity, User $user = null){
        return $this->_model::find()->where([
                'user_id' => $user ? $user->id : Yii::$app->user->id,
                'entity_id' => $entity->id,
                'model' => ModelHelper::getModelName($entity)
             ])
            ->one();
    }
    
    public function getItems(User $user){
        return $this->_model::find()->where([
                'user_id' => $user ? $user->id : Yii::$app->user->id
             ])
            ->limit($this->_model::MAX_ITEMS_WISH)
            ->all();
    }
    
    public function getCount(){
        return (new \yii\db\Query())->select('COUNT(id)')
                ->from($this->_model::tableName())
                ->where([
                    'user_id' => \Yii::$app->user->id
                ])
                ->count();
    }
    
}
