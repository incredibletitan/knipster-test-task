<?php

namespace App\Http\Requests;

class StoreUserRequest extends JsonRequest
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
        $lettersOnly = 'regex:/(^[A-Za-z]+$)+/';
        return [
            'email' => 'required|email|unique:user',
            'first_name' => 'min:2|' . $lettersOnly,
            'last_name' => 'min:2|' . $lettersOnly,
            'country' => 'required|' . $lettersOnly,
            'gender' =>  $lettersOnly,
        ];
    }
}
