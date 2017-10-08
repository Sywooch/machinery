<?php

namespace common\modules\payment\services;

use common\modules\payment\models\InvoiceRepository;
use yii;
use common\modules\payment\models\Invoice;
use common\modules\payment\models\PaymentAccount;

class InvoiceService
{

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * InvoiceService constructor.
     * @param InvoiceRepository $invoiceRepository
     */
    function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param PaymentAccount $account
     * @param int $amount
     * @param string $message
     * @param array $data
     * @return object
     */
    public function createInvoice(PaymentAccount $account, int $amount, string $message = '', array $data = [])
    {
        $invoice = \Yii::createObject([
            'class' => Invoice::class,
            'account_id' => $account->id,
            'amount' => $amount,
            'message' => $message,
            'data' => array_merge($data, [
                'ip' => Yii::$app->request->getUserIP()
            ])
        ]);
        $invoice->save();
        return $invoice;
    }

    /**
     * @param int $id
     * @return static
     */
    public function getInvoiceById(int $id){
        return $this->invoiceRepository->getInvoceById($id);
    }

    /**
     * @param Invoice $invoice
     * @param int $status
     * @return bool
     */
    public function updateInvoiceStatus(Invoice $invoice, int $status){
        $invoice->status = $status;
        return $invoice->save();
    }
}