<?php

namespace common\modules\search\widgets\SearchForm;

use yii\bootstrap\Widget;

class SearchFormWidget extends Widget
{

    /**
     * @var string
     */
    public $action = '/search';

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('search-form-widget', [
            'action' => $this->action
        ]);
    }
}
