<?php

namespace common\modules\store\models;

use common\models\Alias;

interface ProductInterface 
{
    /**
     * 
     * @param Alias $alias
     * @return mixed
     */
    public function urlPattern(Alias $alias);
  
}

