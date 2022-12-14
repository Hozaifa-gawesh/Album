<?php

namespace App\Http\Requests\Front\Album;

use App\Constants\ConstantsGeneral;
use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumListRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', Rule::in(Album::STATUS_ALBUM)],
            'paginate' => ['nullable', 'integer', 'between:10,100'],
            'sort_by' => ['nullable', 'string', Rule::in(ConstantsGeneral::SORTING)],
        ];
    }
}
