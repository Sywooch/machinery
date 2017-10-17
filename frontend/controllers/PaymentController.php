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
use frontend\components\PayPalDirectComponent;
use frontend\models\Order;
use Yii;
use frontend\models\Callback;
use frontend\models\CallbackSearch;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
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
                        'actions' => ['pay','create-invoice'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['result','success'],

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


    public function actionSuccess(){
        return $this->render('success');
    }

    /**
     * @param int $id
     */
    public function actionCreateInvoice(int $id){

        $invoice = $this->createOptionsInvoice($id);

        return $this->redirect(['/payment/pay?uuid='.$invoice->uuid])->send();
    }

    /**
     * @param string $uuid
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionPay(string $uuid)
    {

        $order = new Order();

        $invoice = $this->_invoiceService->getInvoiceByUuid($uuid);

        if (!$invoice) {
            throw new NotFoundHttpException('Invalid invoice '.$uuid.'.');
        }


        if ($order->load(Yii::$app->request->post()) && $order->validate()) {

            try {
                $PayPalDirect = new PayPalDirectComponent();
                $transaction = $PayPalDirect->doDirectPay($order);
                if(!$transaction){
                    Yii::$app->session->setFlash('error', $PayPalDirect->getErrors());
                }else{
                    $this->_paymentManager->completeInvoice($invoice, $transaction);
                    switch (ArrayHelper::getValue($invoice, 'data.type')) {
                        case 'options':
                            $advert = Advert::findOne($invoice->data['entity_id']);
                            if (!$advert) {
                                Yii::$app->session->setFlash('Payment success but advert for invoice '.$uuid.' not found.');
                            }else{
                                $this->_advertService->updateOptions($advert);
                                return $this->redirect(['/payment/success'])->send();
                            }
                            break;
                    }
                }
            } catch (\Exception $e) {
                throw new BadRequestHttpException('Something wrong.');
            }
        }

        return $this->render('form', ['order' => $order]);
    }



    /**
     * @param int $id
     * @return object
     * @throws NotFoundHttpException
     */
    private function createOptionsInvoice(int $id)
    {

        $advert = Advert::findOne($id);

        if (!$advert) {
            throw new NotFoundHttpException('Advert not found.');
        }

        if (!$advert->order_options) {
            throw new NotFoundHttpException('Advert have no preorder options.');
        }

        if ($advert->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('You are not the owner of advert.');
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
