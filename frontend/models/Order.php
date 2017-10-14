<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class Order extends Model
{

    public $agree;
    public $cardtype;
    public $creditcard;
    public $month;
    public $year;
    public $ccv;
    public $name;
    public $lastname;
    public $phone;
    public $email;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $statenoneusa;
    public $zip;
    public $country;
    public $comment;

    public $total;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[  'year', 'month', 'ccv'], 'integer'],
            [['name', 'lastname', 'email', 'phone', 'address1', 'city', 'zip', 'country', 'agree'], 'required'],
            [['creditcard', 'cardtype', 'ccv', 'month', 'year'], 'required'],
            [['statenoneusa'], 'required', 'when' => function ($model) {
                return $model->country != 'US';
            }, 'whenClient' => "function (attribute, value) {
        return ($('#cartorders-country').val() && $('#cartorders-country').val() != 'US');
    }"], [['state'], 'required', 'when' => function ($model) {
                return $model->country == 'US';
            }, 'whenClient' => "function (attribute, value) {
        return ($('#cartorders-country').val() && $('#cartorders-country').val() == 'US');
    }"],
            [['comment'], 'string'],
            [['name', 'lastname', 'phone', 'cardtype', 'creditcard', 'address1', 'address2', 'city', 'statenoneusa', 'zip', 'country', 'state'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'First name',
            'lastname' => 'Last name',
            'ccv' => 'Cvc',
            'email' => 'Email address',
            'phone' => 'Phone number',
            'comment' => 'Comment',
            'created' => 'Created',
            'status' => 'Status',
            'cardtype' => 'Card Type',
            'creditcard' => 'Credit card',
            'statenoneusa' => 'State (if not US)',
            'zip' => 'Zip/Post Code',
            'agree' => 'Agreement'
        ];
    }

    public function init()
    {
        $this->creditcard = '5168742722184151';
        $this->month = 5;
        $this->year = 2019;
        $this->ccv = '111';
        $this->name = 'Alexander';
        $this->lastname = 'Naumets';
        $this->phone = '+380636308315';
        $this->email = 'revardy-buyer@gmail.com';
        $this->address1 = 'Kalinovka, Kievskaya obl., Vasilcovskii r-n.';
        $this->city = 'Kiev';
        $this->statenoneusa = 'Kiev';
        $this->zip = '0863';

        parent::init(); // TODO: Change the autogenerated stub
    }

    public function beforeValidate()
    {

        $this->creditcard = str_replace(' ', '', $this->creditcard);
        if (!preg_match('/^[\d]{16}$/', $this->creditcard)) {
            $this->addError('creditcard', 'Creadit card has a wrong format');
        }


      //  $this->subtotal = 10;
       // $this->shipment = 1;
       // $this->tax = 0;
        $this->total = 11;

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function getStates()
    {
        $data = ['' => 'State'];
        $rows = (new \yii\db\Query())
            ->select('*')
            ->from('states')->orderBy([
                'name' => SORT_ASC,
            ])->all();

        foreach ($rows as $row) {
            $data[$row['name']] = $row['name'];
        }
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getCountryes()
    {
        $data = ['' => 'Country', 'US' => 'USA'];
        $rows = (new \yii\db\Query())
            ->select('*')
            ->from('country')->all(); //->createCommand()

        foreach ($rows as $row) {
            if ($row['id'] != "US")
                $data[$row['id']] = $row['name'];
        }
        return $data;
    }


}
