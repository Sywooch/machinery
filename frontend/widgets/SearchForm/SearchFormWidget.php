<?php

namespace frontend\widgets\SearchForm;

use Yii;
use frontend\widgets\SearchForm\models\Search;
use common\modules\taxonomy\models\TaxonomyItems;

class SearchFormWidget extends \yii\bootstrap\Widget
{
    private $searchFormModel;

    public function __construct(Search $searchFormModel, $config = array())
    {
        parent::__construct($config);
        $this->searchFormModel = $searchFormModel;
    }

    public function run()
    {
        $categories = TaxonomyItems::find()
            ->where([
                'vid' => 2,
                'pid' => 0
            ])
            ->orderBy(['weight' => SORT_ASC])
            ->all();
        $this->searchFormModel->load(Yii::$app->request->get());
        return $this->render('search-form-widget', [
            'model' => $this->searchFormModel,
            'categories' => $categories,
        ]);
    }
}
