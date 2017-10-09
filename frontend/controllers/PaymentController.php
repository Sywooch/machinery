<?php

namespace frontend\controllers;

use common\models\Advert;
use common\models\AdvertOption;
use common\models\TarifOptions;
use common\modules\payment\models\Invoice;
use common\modules\payment\PaymentManager;
use common\modules\payment\services\AccountService;
use common\modules\payment\services\InvoiceService;
use common\services\AdvertService;
use Yii;
use frontend\models\Callback;
use frontend\models\CallbackSearch;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Settings;


class PaymentController extends Controller
{

    private $_invoiceService;
    private $_accountService;
    private $_paymentManager;
    private $_advertService;

    public function __construct($id, Module $module, InvoiceService $invoiceService, AccountService $accountService, PaymentManager $paymentManager, AdvertService $advertService, array $config = [])
    {
        $this->_paymentManager = $paymentManager;
        $this->_invoiceService = $invoiceService;
        $this->_accountService = $accountService;
        $this->_advertService = $advertService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['pay'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['result'],

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'send' => ['POST'],
                ],
            ],
        ];
    }

    public function actionResult()
    {

        //TODO: Get and check merchant response

        $invoiceId = 104;

        $invoice = $this->_invoiceService->getInvoiceById($invoiceId);

        if (!$invoice) {
            throw new NotFoundHttpException('Invalid invoice '.$invoiceId.'.');
        }

        try {
            $this->_paymentManager->completeInvoice($invoice);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Invalid invoice '.$invoiceId.'.');
        }


        switch (ArrayHelper::getValue($invoice, 'data.type')) {
            case 'options':
                $advert = Advert::findOne($invoice->data['entity_id']);

                if (!$advert) {
                    throw new NotFoundHttpException('Advert for invoice '.$invoiceId.' not found.');
                }

                $this->_advertService->updateOptions($advert);
                break;
        }

        exit('ADDDDD');
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPay(int $id)
    {


        $invoice = $this->createOptionsInvoice($id);

        //TODO: DO Payment

        exit('MMMM');
    }

    /**
     * @param int $id
     * @return object
     * @throws NotFoundHttpException
     */
    private function createOptionsInvoice(int $id)
    {

        $advert = Advert::findOne($id);

        if (!$advert || !$advert->order_options) {
            throw new NotFoundHttpException('Advert not found.');
        }

        $amount = (int)TarifOptions::find()->where(['in', 'id', $advert->getAdvertOrderOptions()])->sum('price');

        return $this->_invoiceService->createInvoice($this->findAccount(), $amount, 'Payment for additional items', [
            'type' => 'options',
            'entity_id' => $advert->id
        ]);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    private function findAccount()
    {
        $account = $this->_accountService->getUserAccount(Yii::$app->user->identity);

        if (!$account) {
            $this->_accountService->createAccounts(Yii::$app->user->identity);
            $account = $this->_accountService->getUserAccount(Yii::$app->user->identity);
        }

        return $account;
    }


}
