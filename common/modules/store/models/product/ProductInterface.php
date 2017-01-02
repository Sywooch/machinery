<?php

namespace common\modules\store\models\product;

use yii\db\ActiveRecordInterface;
use common\models\Alias;
use common\modules\store\models\order\OrderItemInterface;

interface ProductInterface extends ActiveRecordInterface, OrderItemInterface
{
    /**
     * 
     * @param Alias $alias
     * @return mixed
     */
    public function urlPattern(Alias $alias);
  
}

