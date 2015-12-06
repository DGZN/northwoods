<?php

namespace App\Billing;


use Validator;

class CreditCard
{
    /**
     * Credit Card errors.
     */
    protected $errors = false;

    /**
     * Credit Card;
     */
    protected $card;

    /**
     * Create a CreditCard instance.
     *
     * @return void
     */
    public function __construct($card)
    {
        return $this->create($card);
    }

    /**
     * Returns CreditCard Instance.
     *
     * @return {mixed} App\Billing\CreditCard
     */
    public function get()
    {
        return $this->card;
    }

    /**
     * Validates a Credit Card Object
     *
     * @return {mixed} App\Billing\CreditCard
     */
    public function create($card)
    {
        $validator = Validator::make($card, [
            'card_number' => 'required|max:20',
            'exp_date'    => 'required',
        ]);

        if ($validator->fails()) {

            $this->errors = $validator->errors()->getMessages();

            return $this;

        }

        $this->setCard($card);
        return $this;
    }

    /**
     * Validates CreditCard Instance.
     *
     * @return {boolean}
     */
    public function isValid()
    {
        if (!$this->errors) {
            return true;
        }

        return false;
    }

    /**
     * Returns CreditCard Errors.
     *
     * @return {array} $this->errors
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Sets protected card property.
     *
     * @return {array} $this->errors
     */
    private function setCard($card)
    {
        $this->card = $card;
    }

}
