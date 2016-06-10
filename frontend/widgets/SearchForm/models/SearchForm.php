<?php

namespace frontend\widgets\SearchForm\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SearchForm extends Model
{
    public $search;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search', 'email', 'subject', 'body'], 'string'],
        ];
    }

}
