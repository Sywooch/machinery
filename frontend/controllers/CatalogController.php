<?php

namespace frontend\controllers;

use common\models\AdvertRepository;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use frontend\models\FilterForm;
use yii\data\Sort;
use yii\web\Controller;
use common\helpers\ModelHelper;
use yii;

class CatalogController extends Controller
{

    /**
     * @var AdvertRepository
     */
    private $_advertRepository;

    /**
     * @var TaxonomyItemsRepository
     */
    private $_taxonomyItemsRepository;

//    /**
//     * @var SearchModule
//     */
//    private $_search;

    /**
     * CatalogController constructor.
     * @param string $id
     * @param yii\base\Module $module
     * @param AdvertRepository $advertRepository
     * @param TaxonomyItemsRepository $taxonomyItemsRepository
     * @param array $config
     */
    public function __construct($id, $module, AdvertRepository $advertRepository, TaxonomyItemsRepository $taxonomyItemsRepository, array $config = [])
    {
        $this->_advertRepository = $advertRepository;
        $this->_taxonomyItemsRepository = $taxonomyItemsRepository;
       // $this->_search = Yii::$app->getModule('search');

        parent::__construct($id, $module, $config);

    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $filter = new FilterForm();
        $params = Yii::$app->request->get('Search') ? Yii::$app->request->get('Search') : \Yii::$app->request->get();
        $filter->load(['FilterForm' => $params]);

        $sort = new Sort([
            'attributes' => [
                'age',
                'title' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_ASC],
                    'label' => 'Title',
                ],
                'date' => [
                    'asc' => ['updated' => SORT_ASC],
                    'desc' => ['updated' => SORT_ASC],
                    'label' => 'Date',
                ],
            ],
        ]);

        $categoryCounts = $this->_advertRepository->getSubCategories($this->_advertRepository->searchQueryByFilter($filter));
        
        return $this->render('index', [
            'dataProvider' => $this->_advertRepository->searchByFilter($this->_advertRepository->searchQueryByFilter($filter), $sort),
            'categories' => $categoryCounts ? $this->_taxonomyItemsRepository->getByIds(array_keys($categoryCounts)) : [],
            'categoryCounts' => $categoryCounts,
            'sort' => $sort,
        ]);
    }

}