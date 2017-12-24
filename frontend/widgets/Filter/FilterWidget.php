<?php

namespace frontend\widgets\Filter;

use common\modules\taxonomy\models\TaxonomyItemsRepository;
use frontend\models\FilterForm;
use frontend\widgets\Filter\services\FilterService;
use Yii;
use yii\bootstrap\Widget;
use common\models\AdvertRepository;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


class FilterWidget extends Widget
{

    /** @var FilterForm  */
    private $_model;

    /** @var AdvertRepository  */
    private $_advertRepository;


    /** @var FilterService  */
    protected $_filterService;


    /**
     * FilterWidget constructor.
     * @param FilterForm $model
     * @param FilterService $filterService
     * @param AdvertRepository $_advertRepository
     * @param array $config
     */
    public function __construct(FilterForm $model, FilterService $filterService, AdvertRepository $_advertRepository,  $config = array())
    {
        $this->_model = $model;
        $this->_filterService = $filterService;
        $this->_advertRepository = $_advertRepository;
        parent::__construct($config);
    }

    public function run()
    {

        $categories = $this->_filterService->findCategories(Yii::$app->request->get());

        return $this->render('filter-widget', [
            'model' => $this->_model,
            'categories' => $categories,
            'categoriesJson' => Json::encode($categories),
            'priceMin' => floor($this->_advertRepository->getMinPrice()),
            'priceMax' => ceil($this->_advertRepository->getMaxPrice()),
        ]);
    }

}
