<?php

namespace frontend\controllers;

use common\models\AdvertRepository;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use frontend\models\FilterForm;
use yii\data\Sort;
use yii\web\Controller;
use common\helpers\ModelHelper;
use yii\helpers\Json;
use frontend\helpers\CatalogHelper;

use common\modules\search\Module as SearchModule;
use yii;

class AjaxController extends Controller
{

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
    private $_search;

    /**
     * CatalogController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param AdvertRepository $advertRepository
     * @param array $config
     */
    public function __construct($id, $module, AdvertRepository $advertRepository, TaxonomyItemsRepository $taxonomyItemsRepository, array $config = [])
    {
        $this->_advertRepository = $advertRepository;
        $this->_taxonomyItemsRepository = $taxonomyItemsRepository;
        $this->_search = Yii::$app->getModule('search');

        parent::__construct($id, $module, $config);

    }

    public function actionCategories($id=null)
    {
        if(\Yii::$app->request->isAjax){
            if(!$id) return Json::encode(['0'=>'']);
            $filter = new FilterForm();
            $filter->load(\Yii::$app->request->get());

            $categoryCounts = $this->_advertRepository->getSubCategories($this->_advertRepository->searchQueryByFilter($filter));
            $categories = $categoryCounts ? $this->_taxonomyItemsRepository->getByIds(array_keys($categoryCounts)) : [];
            $out = [];
            $_cats = TaxonomyHelper::tree($categories, $id);
            $cats = CatalogHelper::tree2flat($_cats);


            unset($cats[$id]);
            foreach ($cats as $category) {
                if ($category['pid'] && $category['vid'] == 2) {
                    $out[$category['id']] = "<option value='" . $category['id'] . "' class='level-".$category['level']."' data-translit='" . $category['transliteration'] . "'>" .
                        $category['title'] . " (" . $categoryCounts[$category['id']]['c'] . ")</option>";
                }
            }
            return Json::encode($out);
        }


    }

    /**
     * @return string
     */
    public function actionIndex($id)
    {
        $filter = new FilterForm();
        $filter->load(\Yii::$app->request->get());

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