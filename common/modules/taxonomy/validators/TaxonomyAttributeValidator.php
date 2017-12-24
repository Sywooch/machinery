<?php

namespace common\modules\taxonomy\validators;

use yii\validators\Validator;
use common\modules\taxonomy\models\TaxonomyItems;

class TaxonomyAttributeValidator extends Validator
{

    public $type = 'array';

    public function validateAttribute($model, $attribute)
    {

        $data = $model->{$attribute};
        echo $this->type;
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

                if (!($item instanceof TaxonomyItems) && !(int)$item) {
                    $this->addError($model, $attribute, 'Invalid term or id input.');
                    return;
                }
            }

        } elseif (!($data instanceof TaxonomyItems)) {
            $this->addError($model, $attribute, 'Invalid term input.');
            return;
        }

        return true;
    }

}
