<?php

namespace common\modules\taxonomy\widgets\Field;

use yii\base\Widget;
use common\modules\taxonomy\models\TaxonomyItems;

class TaxonomyField extends Widget {

    public $model, $attribute, $vocabularyId;

    public function run() {
        $attribute = $this->attribute;

        if ($this->model->{$attribute}) {
            $this->model->{$attribute} = TaxonomyItems::findAll($this->model->{$attribute});
        }
        
        return $this->render('field', [
                        'field' => $this
        ]);
    }

}
