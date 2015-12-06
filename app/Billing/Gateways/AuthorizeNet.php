<?php

namespace App\Billing\Gateways;

use net\authorize\api\contract\v1 as AuthAPI;
use net\authorize\api\controller  as AuthController;

class AuthorizeNet
{
    /**
     * net\authorize\api\constants\ANetEnvironment
     *
     */
    protected $env;

    /**
     * net\authorize\api\controller\CreditCardType
     *
     */
    protected $card;

    /**
     *
     * net\authorize\api\controller\CustomerAddressType
     *
     */
    protected $info;

    /**
     * Create a AuthorizeNet instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->env = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
        $this->authenticate();

        $this->refId = 'ref' . time();
    }

    /**
     * Authenticates with Payment Gateway.
     *
     * @return void
     */
     function authenticate()
     {
         $AuthID  = env('AUTHNET_LOGIN_ID');
         $AuthKey = env('AUTHNET_TRANSACTION_KEY');

         $this->auth = new AuthAPI\MerchantAuthenticationType();
         $this->auth->setName($AuthID);
         $this->auth->setTransactionKey($AuthKey);
     }

     /**
      * Charges a Saved Customer Account.
      *
      * @param {string} $id
      * @param {float}  $amount
      * @return void
      */
      function chargeCustomer($customer, $amount)
      {
          $profile = new AuthAPI\CustomerProfilePaymentType();
          $profile->setCustomerProfileId($customer['profileID']);
          $payment = new AuthAPI\PaymentProfileType();
          $payment->setPaymentProfileId($customer['paymentID']);
          $profile->setPaymentProfile($payment);

          $requestType = new AuthAPI\TransactionRequestType();
          $requestType->setTransactionType( "authCaptureTransaction");
          $requestType->setAmount($amount);
          $requestType->setProfile($profile);

          $req = new AuthAPI\CreateTransactionRequest();
          $req->setMerchantAuthentication($this->auth);
          $req->setRefId($this->refId);
          $req->setTransactionRequest($requestType);
          $_req = new AuthController\CreateTransactionController($req);
          $res = $_req->executeWithApiResponse($this->env);


          if ($res == null) {

              return [
                  'status' => 'ERROR',
                  'error'  => 'No response from server'
              ];

          }

          return $this->validateTransaction($res->getTransactionResponse());
      }

     /**
      * Returns Customers from Payment Gateway.
      *
      * @return void
      */
     public function getProfileIDs()
     {
         $req = new AuthAPI\GetCustomerProfileIdsRequest();
         $req->setMerchantAuthentication($this->auth);
         $_reg = new AuthController\GetCustomerProfileIdsController($req);
         $res = $_reg->executeWithApiResponse($this->env);

         if ($res == null) {

             return [
                 'status' => 'ERROR',
                 'error'  => 'No response from server'
             ];

         }

         if ($res->getMessages()->getResultCode() != "Ok") {

             $messages = $res->getMessages()->getMessage()[0];

             return [
                 'status' => 'ERROR',
                 'code'   => $messages->getCode(),
                 'error'  => $messages->getText()
             ];

         }

         return $res->getIds();
     }


    /**
     * Saves Customer with Payment Gateway.
     *
     * @return void
     */
    public function saveCustomer($customer)
    {
        $this->card = $this->saveCreditCard($customer->getCard());
        $this->info = $this->saveBillingInformation($customer->getInfo());

        return $this->createCustomerProfile($this->card, $this->info);
    }

    /**
     * Saves Customer Credit Card.
     *
     * @return void
     */
    public function saveCreditCard($card)
    {
        $creditCard = new AuthAPI\CreditCardType();
        $creditCard->setCardNumber($card['card_number']);
        $creditCard->setExpirationDate($card['exp_date']);

        $paymentCreditCard = new AuthAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        return $paymentCreditCard;
    }

    /**
     * Saves Customer Billing Information.
     *
     * @return void
     */
    public function saveBillingInformation($info)
    {
        $billto = new AuthAPI\CustomerAddressType();
        $billto->setFirstName($info['email']);
        $billto->setFirstName($info['first_name']);
        $billto->setLastName($info['last_name']);
        $billto->setAddress($info['address']);
        $billto->setCity($info['city']);
        $billto->setState($info['state']);
        $billto->setZip($info['zip']);
        $billto->setCountry($info['country']);

        return $billto;
    }

    public function createCustomerProfile($card, $info)
    {
        $profile = new AuthAPI\CustomerPaymentProfileType();
        $profile->setCustomerType('individual');
        $profile->setBillTo($info);
        $profile->setPayment($card);
        $profiles[] = $profile;
        $customer = new AuthAPI\CustomerProfileType();
        $merchantCID = time().rand(1,150);
        $customer->setMerchantCustomerId($merchantCID);
        $customer->setPaymentProfiles($profiles);

        $req = new AuthAPI\CreateCustomerProfileRequest();
        $req->setMerchantAuthentication($this->auth);
        $req->setRefId($this->refId);
        $req->setProfile($customer);

        $_req = new AuthController\CreateCustomerProfileController($req);
        $res = $_req->executeWithApiResponse($this->env);

        if ($res == null) {

            return [
                'status' => 'ERROR',
                'error'  => 'No response from server'
            ];

        }

        if ($res->getMessages()->getResultCode() != "Ok") {

            $messages = $res->getMessages()->getMessage()[0];

            return [
                'status' => 'ERROR',
                'code'   => $messages->getCode(),
                'error'  => $messages->getText()
            ];

        }

        $profileID = $res->getCustomerProfileId();
        $paymentID = $res->getCustomerPaymentProfileIdList()[0];

        return [
            'status' => 'Success',
            'data'   => [
                'profileID'        => $profileID,
                'paymentProfileID' => $paymentID
            ]
        ];
    }

    private function validateTransaction($transaction)
    {
        $code = $transaction->getResponseCode();

        if ($code == 2) {

            $error = 'Error charging customers credit card';

        }

        if ($code == 4) {

            $error = 'Transaction held for review';

        }

        if ($code != 1) {

            return [
                'status' => 'ERROR',
                'error'  => $transaction
            ];

        }

        return [
            'auth_code'      => $transaction->getAuthCode(),
            'transactionID'  => $transaction->getTransId()
        ];
    }

}
