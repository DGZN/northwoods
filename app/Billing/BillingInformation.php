<?php

namespace App\Billing;


use Exception;
use Validator;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class BillingInformation extends ExceptionHandler
{
    /**
     * Billing Information errors.
     */
    protected $errors = false;

    /**
     * Billing Information
     */
    protected $info;

    /**
     * Create a BillingInformation instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        return $this->create($info);
    }

    public function create($info)
    {
        $validator = Validator::make($info, [
            'first_name'   => 'required',
            'last_name'    => 'required',
            'address'      => 'required',
            'city'         => 'required',
            'state'        => 'required',
            'zip'          => 'required',
            'country'      => 'required',
        ]);

        if ($validator->fails()) {

            $this->errors = $validator->errors()->getMessages();

            return $this;

        }

        $this->setInfo($info);
        return $this;
    }

    public function isValid()
    {
        if (!$this->errors) {
            return true;
        }

        return false;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function get()
    {
        return $this->info;
    }

    private function setInfo($info)
    {
        $this->info = $info;
    }
}
