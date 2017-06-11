<?php

namespace common\modules\store\models;

use Yii;
use common\modules\store\Finder;
use common\modules\taxonomy\models\TaxonomyItems;

class FilterModel extends \yii\base\Model
{
    /**
     * @var string
     */
    public $_priceRange = '250, 10000';

    /**
     * @var
     */
    public $_priceMin;

    /**
     * @var
     */
    public $_priceMax;

    /**
     * @var
     */
    public $index;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priceMin', 'priceMax'], 'integer'],
            [['index'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'priceRange' => 'Подобрать по цене:',
        ];
    }

    /**
     *
     * @return string
     */
    public function getPriceRange()
    {
        return implode(',', [$this->priceMin, $this->priceMax]);
    }


    /**
     *
     * @return int
     */
    public function getPriceMin()
    {
        if ($this->_priceMin === null) {
            $this->_priceMin = 950;
        }
        return $this->_priceMin;
    }

    /**
     *
     * @param int $price
     */
    public function setPriceMin($price)
    {
        $this->_priceMin = $price;
    }

    /**
     *
     * @return int
     */
    public function getPriceMax()
    {
        if ($this->_priceMax === null) {
            $this->_priceMax = 20000;
        }
        return $this->_priceMax;
    }

    /**
     *
     * @param int $price
     */
    public function setPriceMax($price)
    {
        $this->_priceMax = $price;
    }


}
