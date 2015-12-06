<?php

namespace App\Billing;

use App\Billing\Customer;
use App\Billing\Gateways\AuthorizeNet as Gateway;

class PaymentGateway
{

    /**
     * Payment Gateway Facade.
     */
    protected $gateway;

    /**
     * Create a Payment Gateway instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->gateway = (new Gateway);
    }

    /**
     * Charges a Customer's Account.
     *
     * @param  App/Billing/Customer $customer
     * @param  {float}              $amount
     * @return void
     */
    public function charge($customer, $amount)
    {
        return $this->gateway->chargeCustomer($customer, $amount);
    }

    /**
     * Saves a Customer with the Payment Gateway.
     *
     * @return void
     */
    public function saveCustomer(Customer $customer)
    {
        return $this->gateway->saveCustomer($customer);
    }

    /**
     * Returns Customers from Payment Gateway.
     *
     * @return void
     */
    public function getProfileIDs()
    {
        return $this->gateway->getProfileIDs();
    }



}
