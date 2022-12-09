<?php

namespace App\Http\Requests\Front\Album;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlbum extends FormRequest
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
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('albums', 'name')->ignore($this->route('album_id'))
            ],
            'status' => [
                'required', Rule::in(array_keys(Album::STATUS_ALBUM))
            ],
        ];
    }
}
