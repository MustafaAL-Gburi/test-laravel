<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBerufRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
{
    return [
        'beruf' => 'required|string|max:255',
        'status' => 'nullable|integer|min:0|max:255',
        'ba_id' => 'nullable|integer|min:0',
        'maennlich' => 'nullable|string|max:100',
        'weiblich' => 'nullable|string|max:100',
        'ba_zustand' => 'nullable|string|size:1',
        'keywords' => 'nullable|string|max:250',
        'fragebogen_id' => 'nullable|integer'
    ];
}
}
