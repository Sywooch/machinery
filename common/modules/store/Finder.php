<?php

namespace common\modules\store;

use common\modules\store\models\product\ProductRepository;
use Yii;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use common\modules\store\classes\uus\UUS;
use common\modules\store\components\StoreUrlRule;
use common\modules\store\models\product\ProductInterface;
use common\modules\store\models\compare\ComparesSearch;
use common\modules\taxonomy\models\TaxonomyItems;
use common\models\User;
use yii\data\Sort;

class Finder extends Object
{

    /**
     * @var
     */
    public $module;

    /**
     * @var ProductInterface|null
     */
    public $model;

    /**
     * @var ProductRepository
     */
    private $_productRepository;

    /**
     * @var ComparesSearch
     */
    private $_comparesSearch;

    /**
     * @var UUS
     */
    private $_uus;

    private $_sort;

    /**
     * Finder constructor.
     * @param ProductInterface|null $model
     * @param ProductRepository $productRepository
     * @param ComparesSearch $comparesSearch
     * @param UUS $uus
     * @param array $config
     */
    public function __construct(ProductInterface $model = null, ProductRepository $productRepository, ComparesSearch $comparesSearch, UUS $uus, $config = array())
    {
        $this->_uus = $uus;
        $this->model = $model;
        $this->_productRepository = $productRepository;
        if ($model) {
            $this->_productRepository->setModel($model);
        }
        $this->_comparesSearch = $comparesSearch;

        parent::__construct($config);
    }

    public function getUus()
    {
        return $this->_uus;
    }

    public function getProdutSearch()
    {
        return $this->_produtSearch;
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        return $this->_produtSearch->search($params);
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
     *
     * @param int $id
     * @return mixed
     */
    public function getProductById($id)
    {
        return current($this->getProductsByIds([$id]));
    }

    /**
     *
     * @param array $ids
     * @return mixed
     */
    public function getProductsByIds(array $ids)
    {
        return $this->_produtSearch->getProductsByIds($ids);
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
     *
     * @param TaxonomyItems $taxonomyItem
     * @return type
     */
    public function getMostRatedId(TaxonomyItems $taxonomyItem)
    {
        return $this->_produtSearch->getMostRatedId($taxonomyItem);
    }


    public function getWishItems(User $user)
    {
        return $this->_wishSearch->getItems($this->_wishSearch->getIds($user));
    }

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