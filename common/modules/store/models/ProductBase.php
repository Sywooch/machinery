<?php

namespace common\modules\store\models;

use yii\db\ActiveRecord;
use common\modules\product\helpers\ProductHelper;
use common\modules\store\helpers\ProductHelperInterface;
use common\models\Alias;
use common\modules\store\classes\Pricer;


class ProductBase extends ActiveRecord implements ProductInterface
{
    private $_helper;
    
    /**
     * 
     * @param ProductHelperInterface $helper
     */
    public function setHelper(ProductHelperInterface $helper){
        $this->_helper = $helper;
    }
    
    /**
     * 
     * @return \common\modules\product\helpers\ProductHelper
     */
    public function getHelper(){
        return $this->_helper;
    }
    
    /**
     * 
     * @param Alias $alias
     * @param ProductHelper $productHelper
     * @return mixed
     */
    public function urlPattern(Alias $alias){
        return $this->_helper->urlPattern($this, $alias);
    }

}

