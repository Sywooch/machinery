<?php

namespace frontend\widgets\SearchForm\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Search extends Model
{
    public $search;
    public $category;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search', 'email', 'subject', 'body'], 'string'],
            ['category', 'number'],
        ];
    }

}
