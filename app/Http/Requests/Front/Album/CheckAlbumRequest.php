<?php

namespace App\Http\Requests\Front\Album;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckAlbumRequest extends FormRequest
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
            'excluded_album' => [
                'required',
                'integer',
                Rule::exists('albums', 'id')
            ],
            'album' => [
                'required',
                'integer',
                Rule::exists('albums', 'id')->whereNot('id', request('excluded_album'))
            ]
        ];
    }
}
