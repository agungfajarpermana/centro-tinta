<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErrorFormUploadFile extends FormRequest
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
            'file' => 'required|mimes:xlsx,xls'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Tidak boleh kosong!',
            'file.mimes'    => 'Extension tidak sesuai unduhan!'
        ];
    }
}
