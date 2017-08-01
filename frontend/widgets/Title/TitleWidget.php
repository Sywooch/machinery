<?php
namespace frontend\widgets\SearchForm;

use Yii;
use frontend\widgets\SearchForm\models\SearchForm;

class Titleidget extends \yii\bootstrap\Widget
{
    public $title;
    
    public function __construct(SearchForm $searchFormModel, $config = array()) {
        parent::__construct($config);
        $this->searchFormModel = $searchFormModel;
    }
    
    public function run()
    {
        return $this->title;
    }
}
