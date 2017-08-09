<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


/**
 * ContactForm is the model behind the contact form.
 */
class FilterForm extends Model
{
    public $area;
    public $category;
    public $manufacturer;
    public $country;

    public $id;
    public $model;
    public $year;
    public $price;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area', 'category', 'manufacturer', 'country', 'year'], 'integer'],
            ['price', 'safe'],
            [['model', 'id'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'MachineryPark ID'),
            'model' => Yii::t('app', 'Model'),
            'year' => Yii::t('app', 'Year of manufacture from'),
            'area' => Yii::t('app', 'Area'),
            'category' => Yii::t('app', 'Category'),
            'manufacturer' => Yii::t('app', 'Manufacturer'),
            'country' => Yii::t('app', 'Continent / country'),
        ];
    }

}
