<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:contacts,email,' . $this->route('id')],
            'phone' => ['required', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'birthdate' => ['nullable', 'date', 'before:tomorrow'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'The name must be at least 3 characters long.',
            'email.email' => 'Enter a valid email.',
            'email.unique' => 'This email is already in use.',
            'phone.regex' => 'Enter a valid telephone number. (XX) XXXXX-XXXX',
        ];
    }
}
