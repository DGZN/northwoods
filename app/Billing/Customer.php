<?php

namespace App\Billing;


use Exception;
use Validator;

use App\Billing\CreditCard;
use App\Billing\PaymentGateway as PaymentGateway;
use App\Billing\BillingInformation;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Customer extends ExceptionHandler
{

    /**
     * Validation Errors
     *
     * @var {array}
     */
    protected $errors = [];

    /**
     * Saved Customer.
     *
     * @var App/Billing/Customer
     */
    protected $customer;

    /**
     * The Customers Credit Card.
     *
     * @var App/Billing/CreditCard
     */
    protected $creditCard;

    /**
     * The Customers Billing Information.
     *
     * @var App/Billing/BillingInformation
     */
    protected $billingInfo;

    /**
     * Create a Customer instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->gateway = (new PaymentGateway);
    }

    /**
     * Returns Validated Customer Data.
     *
     * @return {array}
     */
    public function get()
    {
        return $this->customer;
    }

    /**
     * Charges a Customer's Account
     *
     * @param  {float} $amount
     * @return void
     */
    public function charge($customer, $amount)
    {
       return $this->gateway->charge($customer, $amount);
    }


    /**
     * Saves a Customer.
     *
     * @return App/Billing/Customer $customer
     */
     public function save()
     {
         if ($this->errors()) {

             return false;

         }

         if ( ! $customer = $this->gateway->saveCustomer($this) ) {

             return false;

         }

         $this->customer = $customer['data'];
         return $this;
     }

     /**
      * Returns Customer Profiles from Payment Gateway.
      *
      * @return {array}
      */
     public function getProfileIDs()
     {
         return $this->gateway->getProfileIDs();
     }

     /**
      * Returns Validated Customer Credit Card.
      *
      * @return App/Billing/CreditCard
      */
     public function getCard()
     {
         return $this->creditCard;
     }

     /**
      * Returns Validated Customer Billing Information.
      *
      * @return App/Billing/BillingInformation
      */
     public function getInfo()
     {
         return $this->billingInfo;
     }

    /**
     * Set a Customers Credit Card Information.
     *
     * @return {class} App/Billing/CreditCard
     */
    public function setCreditCard($obj)
    {
        $card = (new CreditCard($obj));

        if ( ! $card->isValid() ) {

            $this->setError([
              'error'   => $card->errors(),
              'message' => 'Error setting customer credit card.'
            ]);

        }

        $this->creditCard = $card->get();
    }

    /**
     * Set a Customers Billing Information.
     *
     * @return {class} App/Billing/BillingInformation
     */
    public function setBillingInfo($obj)
    {
        $info = (new BillingInformation($obj));

        if ( ! $info->isValid() ) {

            $this->setError([
              'error'   => $info->errors(),
              'message' => 'Error setting customer billing information.'
            ]);

        }

        $this->billingInfo = $info->get();
    }

     /**
      * Gets Customer Validation Errors.
      *
      * @return {array} $errors
      */
     public function errors()
     {
         if (count($this->errors) > 0) {

             return $this->errors;

         }

         return false;
     }

     /**
      * Sets Customer Validation Errors.
      *
      * @param  {array} $errors
      * @return void
      */
     protected function setError($error)
     {
         $this->errors[] = $error;
     }

}
