<?php

namespace frontend\widgets\Filter;

use common\modules\taxonomy\models\TaxonomyItemsRepository;
use frontend\models\FilterForm;
use Yii;
use yii\bootstrap\Widget;
use common\models\AdvertRepository;
use yii\helpers\ArrayHelper;


class FilterWidget extends Widget
{
    const CACHE_TIME = 60 * 60 * 5;

    private $_model;
    /**
     * @var AdvertRepository
     */
    private $_advertRepository;

    /**
     * @var TaxonomyItemsRepository
     */
    private $_taxonomyItemsRepository;

    /**
     * @var SearchModule
     */


    public function __construct(FilterForm $model, AdvertRepository $_advertRepository,  TaxonomyItemsRepository $_taxonomyItemsRepository, $config = array())
    {
        $this->_model = $model;
        $this->_taxonomyItemsRepository = $_taxonomyItemsRepository;
        $this->_advertRepository = $_advertRepository;
        parent::__construct($config);
    }

    public function run()
    {
//        $load = [];
        $load['FilterForm'] = Yii::$app->request->get();
        $this->_model->load($load);
        $_subcats = $this->_model->category ?
            \common\modules\taxonomy\helpers\TaxonomyHelper::tree(
                $this->_taxonomyItemsRepository->getVocabularyTerms(2), $this->_model->category) : [];

        $subcats = \frontend\helpers\CatalogHelper::tree2flat($_subcats);
        unset($subcats[$this->_model->category]);
        return $this->render('filter-widget', [
            'model' => $this->_model,
            'itemsRepository' => $this->_taxonomyItemsRepository,
            'subcats' => $subcats,
            'priceMin' => floor($this->_advertRepository->getMinPrice()),
            'priceMax' => ceil($this->_advertRepository->getMaxPrice()),
        ]);
    }

}
