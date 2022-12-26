<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
         'user_id'=>$this->user()->id
        ]);
    }
    public function rules()
    {
        return [
            'name'=>'required|string',
            'user_id'=>'exists:user,id',
            'price'=>'',
            'description'=>'',
            'image'=>''
        ];
    }
}
