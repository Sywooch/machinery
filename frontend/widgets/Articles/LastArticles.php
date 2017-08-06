<?php

namespace frontend\widgets\Articles;

use Yii;

class LastArticles extends \yii\bootstrap\Widget
{

    public function __construct() {
        parent::__construct();
    }

    public function run()
    {
        return $this->render('articles');
    }

}