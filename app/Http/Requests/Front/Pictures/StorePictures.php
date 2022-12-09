<?php

namespace App\Http\Requests\Front\Pictures;

use App\Constants\ConstantsGeneral;
use Illuminate\Foundation\Http\FormRequest;

class StorePictures extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pictures' => [
                'required',
                'array',
                'max:' . ConstantsGeneral::MAX_FILES_UPLOAD,
            ],
            'pictures.*' => [
                'mimes:jpg,jpeg,png,gif,svg',
                'max:2048'
            ]
        ];
    }
}
