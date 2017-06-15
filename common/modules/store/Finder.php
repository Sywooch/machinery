<?php

namespace common\modules\store;

use common\modules\store\models\product\Product;
use common\modules\store\models\product\ProductRepository;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use common\modules\store\classes\uus\UUS;
use common\modules\store\components\StoreUrlRule;
use common\modules\store\models\product\ProductInterface;
use common\modules\store\models\compare\ComparesSearch;
use common\models\User;
use yii\data\Sort;

class Finder extends Object
{

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var ComparesSearch
     */
    protected $_comparesSearch;

    /**
     * @var UUS
     */
    private $_uus;

    /**
     * @var
     */
    private $_sort;

    /**
     * Finder constructor.
     * @param ProductRepository $productRepository
     * @param ComparesSearch $comparesSearch
     * @param UUS $uus
     * @param array $config
     */
    public function __construct(ProductRepository $productRepository, ComparesSearch $comparesSearch, UUS $uus, $config = array())
    {
        $this->_uus = $uus;
        $this->_productRepository = $productRepository;
        $this->_comparesSearch = $comparesSearch;

        //    parent::__construct($config);
    }

    public function getUus()
    {
        return $this->_uus;
    }

    public function getComparesSearch()
    {
        return $this->_comparesSearch;
    }

    public function getWishSearch()
    {
        return $this->_wishSearch;
    }

    /**
     *
     * @param StoreUrlRule $url
     * @return ActiveDataProvider
     */
    public function searchByUrl(StoreUrlRule $url)
    {
        $this->_sort = new Sort([
            'attributes' => [
                'age',
                'price-asc' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_ASC],
                    'label' => 'от дешевых',
                ],
                'price-desc' => [
                    'asc' => ['price' => SORT_DESC],
                    'desc' => ['price' => SORT_DESC],
                    'label' => 'от дорогих',
                ],
            ],
        ]);

        return $this->_productRepository->search($url, $this->_sort);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProductById(int $id) : Product
    {
        return $this->_productRepository->getById($id);
    }

    /**
     *
     * @param string|array $groups
     * @return [] mixed
     */
    public function getProductsByGroup($groups)
    {
        return $this->getProductsByIds($this->_produtSearch->getProductIdsByGroup($groups));
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getWishItems(User $user)
    {
        return $this->_wishSearch->getItems($this->_wishSearch->getIds($user));
    }

    /**
     * @param ProductInterface|null $entity
     * @return static[]
     */
    public function getCompareItems(ProductInterface $entity = null)
    {
        return $this->_comparesSearch->getItems($this->_comparesSearch->getIds($entity));
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->_sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->_sort = $sort;
    }
}