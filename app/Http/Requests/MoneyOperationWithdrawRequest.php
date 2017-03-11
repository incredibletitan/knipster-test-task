<?php

namespace App\Http\Requests;

class MoneyOperationWithdrawRequest extends JsonRequest
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
            'user_id' => 'required|exists:user,id',
            'amount' => 'required|balanceMoreThanWithdrawAmount:user_id'
        ];
    }
}
