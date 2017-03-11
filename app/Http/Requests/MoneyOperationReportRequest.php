<?php

namespace App\Http\Requests;

class MoneyOperationReportRequest extends JsonRequest
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
            'date_start' => 'date|dateStartLessOrEqualThanEnd:date_end',
            'date_end' => 'date'
        ];
    }
}
