<?php

namespace frontend\components;

use frontend\models\Order;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\AddressType;
use PayPal\EBLBaseComponents\CreditCardDetailsType;
use PayPal\EBLBaseComponents\DoDirectPaymentRequestDetailsType;
use PayPal\EBLBaseComponents\PayerInfoType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\PersonNameType;
use PayPal\PayPalAPI\DoDirectPaymentReq;
use PayPal\PayPalAPI\DoDirectPaymentRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use yii;

class PayPalDirectComponent
{

    private $doDirectPaymentResponse;


    /**
     * @param Order $order
     * @return DoDirectPaymentReq
     */
    private function createDirectPaymentReq(Order $order)
    {
        /*
         * shipping adress
         */

        $address = new AddressType();
        $address->Name = $order->name . ' ' . $order->lastname;
        $address->Street1 = $order->address1;
        $address->Street2 = $order->address2;
        $address->CityName = $order->city;
        $address->StateOrProvince = ($order->country == 'US') ? $order->state : $order->statenoneusa;
        $address->PostalCode = $order->zip;
        $address->Country = $order->country;
        $address->Phone = $order->phone;

        $paymentDetails = new PaymentDetailsType();
        $paymentDetails->ShipToAddress = $address;
        $paymentDetails->OrderTotal = new BasicAmountType('USD', number_format($order->total, 2, ".", ""));


        if (isset($_REQUEST['notifyURL'])) {
            $paymentDetails->NotifyURL = $_REQUEST['notifyURL'];
        }

        $personName = new PersonNameType();
        $personName->FirstName = $order->name;
        $personName->LastName = $order->lastname;


        $payer = new PayerInfoType();
        $payer->PayerName = $personName;
        $payer->Address = $address;
        $payer->PayerCountry = $order->country;

        $cardDetails = new CreditCardDetailsType();
        $cardDetails->CreditCardNumber = $order->creditcard;


        $cardDetails->CreditCardType = $order->cardtype;
        $cardDetails->ExpMonth = $order->month;
        $cardDetails->ExpYear = $order->year;
        $cardDetails->CVV2 = $order->ccv;
        $cardDetails->CardOwner = $payer;


        $ddReqDetails = new DoDirectPaymentRequestDetailsType();
        $ddReqDetails->CreditCard = $cardDetails;
        $ddReqDetails->PaymentDetails = $paymentDetails;

        $doDirectPaymentReq = new DoDirectPaymentReq();
        $doDirectPaymentReq->DoDirectPaymentRequest = new DoDirectPaymentRequestType($ddReqDetails);

        return $doDirectPaymentReq;

    }

    /**
     * @param Order $order
     * @return bool
     */
    public function doDirectPay(Order $order)
    {


        $doDirectPaymentReq = $this->createDirectPaymentReq($order);
        
        $paypalService = new PayPalAPIInterfaceServiceService(Yii::$app->params['paypal']);
        
        $this->doDirectPaymentResponse = $paypalService->DoDirectPayment($doDirectPaymentReq);

        if (isset($this->doDirectPaymentResponse) && $this->doDirectPaymentResponse->Ack == 'Success') {
            return $this->doDirectPaymentResponse;
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function getErrors()
    {
        if (!$this->doDirectPaymentResponse) {
            return false;
        }

        $errors = [];

        foreach ($this->doDirectPaymentResponse->Errors as $err) {

            switch ($err->ErrorCode) {
                case 10527:
                    $errors[] = $err->LongMessage;
                    break;
            }
        }

        if (!$errors) {
            $errors[] = 'We were unable to process your payment. If the problem persists, contact us to complete your order.';
        }


        return $errors;
    }
}