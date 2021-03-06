<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LongUrlRequest extends FormRequest
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
            'long_url' => 'required|url|active_url',
            'short_url' => 'unique:urls,short_url,',
        ];
    }


}
