<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DeleteItemRequest extends FormRequest
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
        $item_name = Str::plural(request('item_name'));

        return [
            'item' => [
                'required',
                'integer',
                Rule::exists($item_name, 'id')
            ],
            'item_name' => [
                'required',
                'string',
            ]
        ];
    }


    public function attributes()
    {
        $item_name = Str::plural(request('item_name'));
        return [
            'item' => __("models/{$item_name}.singular")
        ];
    }
}
