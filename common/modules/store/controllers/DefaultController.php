<?php

namespace common\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\components\StoreUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\Finder;


class DefaultController extends Controller
{
    /**
     * @var Finder
     */
    private $_finder;

    public function __construct($id, $module, Finder $finder, array $config = [])
    {
        $this->_finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param StoreUrlRule $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex(StoreUrlRule $url)
    {
        if (!$url->main) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('index', [
            'finder' => $this->_finder,
            'url' => $url,
            'dataProvider' => $this->_finder->searchByUrl($url),
            'sort' => $this->_finder->sort,
            'parent' => $url->main,
            'current' => $url->category,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'entity' => $this->_finder->getProductById($id)
        ]);
    }

    /**
     * @param StoreUrlRule $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubCategories(StoreUrlRule $url)
    {
        if (!$url->main) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $module = Yii::$app->getModule('store');
        $model = $module->models[$url->main->id];
        $finder = Yii::$container->get(Finder::class, [new $model]);

        $childrensTerms = TaxonomyItems::findAll([
            'vid' => $url->main->vid,
            'pid' => $url->main->id
        ]);

        if (!$childrensTerms) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $items = [];
        foreach ($childrensTerms as $childrenTerm) {
            $products = $finder->getProductsByIds($finder->getMostRatedId($childrenTerm));
            $items[$childrenTerm->id] = [
                'term' => $childrenTerm,
                'products' => $products
            ];
        }
        return $this->render('categories', [
            'parent' => $url->main,
            'items' => $items
        ]);

    }

    /**
     * @param $id
     * @param $model
     * @param $tab
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOtzyvy($id, $model, $tab)
    {
        $finder = Yii::$container->get(Finder::class, [ProductHelper::getModel($model)]);
        $products = $finder->getProductsByGroup($id);

        if (empty($products)) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        return $this->render('index', [
            'products' => $products,
            'product' => current($products),
            'tab' => $tab
        ]);
    }


}
