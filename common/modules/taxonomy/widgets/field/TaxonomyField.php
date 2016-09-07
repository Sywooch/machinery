<?php

namespace common\modules\taxonomy\widgets\field;

use yii\base\Widget;

class TaxonomyField extends Widget {

    public $model, $attribute, $vocabularyId;

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('field', [
                        'field' => $this
        ]);
    }

}
