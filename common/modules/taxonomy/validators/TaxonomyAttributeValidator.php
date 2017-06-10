<?php

namespace common\modules\taxonomy\validators;

use yii\validators\Validator;
use common\modules\taxonomy\models\TaxonomyItems;

class TaxonomyAttributeValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {

        $data = $model->{$attribute};

        if (empty($data)) {
            return;
        }

        if (is_string($data)) {
            foreach (explode(',', $data) as $id) {
                if (!(int)$id) {
                    $this->addError($model, $attribute, 'Invalid term input.');
                    return;
                }
            }
        } elseif (is_array($data)) {
            foreach ($data as $item) {

                if (!(int)$item && !($item instanceof TaxonomyItems)) {
                    $this->addError($model, $attribute, 'Invalid term or id input.');
                    return;
                }
            }

        } elseif (!($data instanceof TaxonomyItems)) {
            $this->addError($model, $attribute, 'Invalid term input.');
            return;
        }
    }

}
