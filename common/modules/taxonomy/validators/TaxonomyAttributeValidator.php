<?php

namespace common\modules\taxonomy\validators;

use yii\validators\Validator;
use common\modules\taxonomy\models\TaxonomyItems;
//use yii\validators\RegularExpressionValidator;

class TaxonomyAttributeValidator extends Validator
{
    /**
     * @var string the regular expression to be matched with
     */
    public $pattern;
    /**
     * @var bool whether to invert the validation logic. Defaults to false. If set to true,
     * the regular expression defined via [[pattern]] should NOT match the attribute value.
     */
    public $not = false;

    public $type = 'array';

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
                if($this->type == 'string'){
                    $valid = !is_array($item) &&
                        (!$this->not && preg_match($this->pattern, $item)
                            || $this->not && !preg_match($this->pattern, $item));
                    return $valid ? null : $this->addError($model, $attribute, 'Invalid term input.');

                } elseif (!($item instanceof TaxonomyItems) && !(int)$item && $this->type !== 'string') {
                    echo "{$this->type} $item eeeee";
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
