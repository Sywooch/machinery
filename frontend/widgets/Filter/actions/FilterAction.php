<?php

namespace frontend\widgets\Filter\actions;

use yii;
use yii\base\Action;
use yii\web\Controller;
use frontend\widgets\Filter\services\FilterService;


class FilterAction extends Action
{

    /** @var FilterService */
    protected $_filterService;

    /**
     * FilterAction constructor.
     * @param string $id
     * @param Controller $controller
     * @param FilterService $filterService
     * @param array $config
     */
    public function __construct($id, Controller $controller, FilterService $filterService, array $config = [])
    {
        $this->_filterService = $filterService;
        parent::__construct($id, $controller, $config);
    }

    /**
     * @return array|void
     */
    public function run()
    {
        \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->_filterService->findCategories(Yii::$app->request->get());
    }
}