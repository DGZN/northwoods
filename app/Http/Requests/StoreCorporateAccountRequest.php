<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCorporateAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'phone'         => 'required',
            'organization'  => 'required',
            'email'         => 'required',
            'validOn'       => 'required',
            // 'address'    => 'required',
            // 'city'       => 'required',
            // 'zip'        => 'required',
            // 'state'      => 'required',
            // 'country'    => 'required'
        ];
    }
}
