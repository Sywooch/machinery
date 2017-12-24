<?php

namespace frontend\widgets\Filter\services;

use common\models\AdvertRepository;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use frontend\helpers\CatalogHelper;
use frontend\models\FilterForm;
use frontend\widgets\Filter\helpers\FilterHelper;
use frontend\widgets\Filter\repositories\TaxonomyIndexRepository;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use yii\web\BadRequestHttpException;

class FilterService
{

    /**
     * @var AdvertRepository
     */
    private $_advertRepository;

    /** @var TaxonomyIndexRepository */
    protected $_indexRepository;

    /** @var TaxonomyItemsRepository */
    protected $_itemsRepository;

    /** @var array */
    public $termsParams = ['category', 'subcategory', 'manufacturer', 'country', 'price'];


    /**
     * FilterService constructor.
     * @param AdvertRepository $advertRepository
     * @param TaxonomyIndexRepository $indexRepository
     * @param TaxonomyItemsRepository $itemsRepository
     */
    public function __construct(AdvertRepository $advertRepository, TaxonomyIndexRepository $indexRepository, TaxonomyItemsRepository $itemsRepository)
    {
        $this->_advertRepository = $advertRepository;
        $this->_indexRepository = $indexRepository;
        $this->_itemsRepository = $itemsRepository;
    }


    /**
     * @param array $data
     * @return array|\yii\db\ActiveRecord
     */
    public function findCategories(array $data)
    {
        $filter = [];

        if (!empty($data)) {
            $filter = array_filter($data, function ($value, $key) {
                return $value && in_array($key, $this->params);
            }, ARRAY_FILTER_USE_BOTH);
        }

        foreach ($this->params as $field) {

            $return[$field] = [];

//            if (isset($filter['subcategory']) && $field == 'category') {
//                unset($filter['subcategory']);
//            }
//
//            if (!isset($filter['category']) && $field == 'subcategory') {
//                continue;
//            }
//
//            if (!isset($filter['category']) && isset($filter['subcategory'])) {
//                unset($filter['subcategory']);
//            }


            $filterModel = new FilterForm();
            $filterModel->load(['FilterForm' => $filter]);
            $indexQuery = $this->_advertRepository->searchQueryByFilter($filterModel);

            $index = $query->column();
            $terms = $this->_itemsRepository->getByIds(array_keys($index));
            $return[$field] = $field == 'subcategory' ? FilterHelper::getCategories($terms, $index) : FilterHelper::getItems($terms, $index);
        }

        $return['counter'] = $this->addCounter($filter);

        return $return;
    }

    /**
     * @param array $filter
     * @return int|string
     */
    private function addCounter(array $filter = [])
    {
        $filterModel = new FilterForm();
        $filterModel->load(['FilterForm' => $filter]);

        return $this->_advertRepository->searchQueryByFilter($filterModel)->count();
    }


}