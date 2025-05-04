<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[А-ЯЁа-яё]+ [А-ЯЁа-яё]+ [А-ЯЁа-яё]+$/u',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^7\d{6}-\d{2}-\d{2}$/',
            ],
            'email' => 'required|email|max:255',
            'question' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'full_name.regex' => 'ФИО должно быть в формате "Имя Фамилия Отчество"',
            'phone.regex' => 'Номер телефона должен быть в формате 7999999-99-99',
        ];
    }
}
