<?php

namespace common\modules\store\helpers;

use common\models\Alias;
use common\modules\store\models\ProductInterface;

interface ProductHelperInterface
{
	public function urlPattern(ProductInterface $product, Alias $alias);
}