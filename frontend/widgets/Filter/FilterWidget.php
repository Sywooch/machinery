<?php

namespace frontend\widgets\Filter;

use common\modules\taxonomy\models\TaxonomyItemsRepository;
use frontend\models\FilterForm;
use Yii;
use yii\bootstrap\Widget;


class FilterWidget extends Widget
{
    const CACHE_TIME = 60 * 60 * 5;

    private $_model;

    private $_itemsRepository;

    public function __construct(FilterForm $model, TaxonomyItemsRepository $itemsRepository, $config = array())
    {
        $this->_model = $model;
        $this->_itemsRepository = $itemsRepository;
        parent::__construct($config);
    }

    public function run()
    {
        $this->_model->load(Yii::$app->request->get());

        return $this->render('filter-widget', [
            'model' => $this->_model,
            'itemsRepository' => $this->_itemsRepository
        ]);
    }

}
