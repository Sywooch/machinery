<?php

namespace common\modules\payment;

use common\modules\payment\exceptions\InvoiceCompleteFailException;
use common\modules\payment\models\PaymentAccount;
use yii;
use common\modules\payment\models\Invoice;
use common\modules\payment\services\AccountService;
use common\modules\payment\services\InvoiceService;
use common\modules\payment\services\TransactionService;

class PaymentManager
{
    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    /**
     * @var AccountService
     */
    protected $accountService;

    /**
     * @var TransactionService
     */
    protected $transactionService;

    /**
     * PaymentManager constructor.
     * @param InvoiceService $invoiceService
     * @param AccountService $accountService
     * @param TransactionService $transactionService
     */
    public function __construct(InvoiceService $invoiceService, AccountService $accountService, TransactionService $transactionService)
    {
        $this->invoiceService = $invoiceService;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    /**
     * @param PaymentAccount $account
     * @param float $amount
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function increase(PaymentAccount $account, float $amount)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->accountService->increase($account, $amount)) {
                $logStatus = $this->transactionService->log($account, $amount, [
                    'message' => 'Increase amount',
                    'user' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->getAttributes(),
                    'ip' => Yii::$app->request->getUserIP()
                ]);
                if ($logStatus) {
                    $transaction->commit();
                    return true;
                }
            }

            throw new InvoiceCompleteFailException('Somesing wrong.');

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @param PaymentAccount $account
     * @param float $amount
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function decrease(PaymentAccount $account, float $amount)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            if ($this->accountService->decrease($account, $amount)) {
                $logStatus = $this->transactionService->log($account, $amount * -1, [
                    'message' => 'Decrease amount',
                    'user' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->getAttributes(),
                    'ip' => Yii::$app->request->getUserIP()
                ]);
                if ($logStatus) {
                    $transaction->commit();
                    return true;
                }
            }

            throw new InvoiceCompleteFailException('Somesing wrong.');

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @param PaymentAccount $from
     * @param PaymentAccount $to
     * @param float $amount
     */
    public function transfer(PaymentAccount $from, PaymentAccount $to, float $amount)
    {

    }


    /**
     * @param Invoice $invoice
     * @return bool
     * @throws InvoiceCompleteFailException
     * @throws \Exception
     * @throws \Throwable
     */
    public function completeInvoice(Invoice $invoice)
    {
        if ($invoice->status === Invoice::STATUS_COMPLETE) {
            throw new InvoiceCompleteFailException('Invoice already completed.');
        }

        if ($invoice->status === Invoice::STATUS_FAIL) {
            throw new InvoiceCompleteFailException('Cannot complete failed invoice.');
        }

        if (!$invoice->account) {
            throw new InvoiceCompleteFailException('Invoice account not found.');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {

            if ($this->accountService->increase($invoice->account, $invoice->amount)) {
                if ($this->invoiceService->updateInvoiceStatus($invoice, Invoice::STATUS_COMPLETE)) {

                    $logStatus = $this->transactionService->log($invoice->account, $invoice->amount, [
                        'message' => 'Complete invoice action',
                        'user' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->getAttributes(),
                        'ip' => Yii::$app->request->getUserIP(),
                        'invoice' => $invoice->attributes()
                    ]);

                    if ($logStatus) {
                        $transaction->commit();
                        return true;
                    }
                }
            }

            throw new InvoiceCompleteFailException('Somesing wrong.');

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

}