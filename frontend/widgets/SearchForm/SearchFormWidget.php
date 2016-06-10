<?php
namespace frontend\widgets\SearchForm;

use Yii;
use frontend\widgets\SearchForm\models\SearchForm;

class SearchFormWidget extends \yii\bootstrap\Widget
{
    private $searchFormModel;
    
    public function __construct(SearchForm $searchFormModel, $config = array()) {
        parent::__construct($config);
        $this->searchFormModel = $searchFormModel;
    }
    
    public function run()
    {
       
        $this->searchFormModel->load(Yii::$app->request->get());
        return $this->render('search-form-widget', [
                'model' => $this->searchFormModel,
        ]);
    }
}
