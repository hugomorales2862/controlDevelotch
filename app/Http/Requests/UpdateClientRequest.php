<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client') ? $this->route('client')->cli_id : null;

        return [
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($clientId, 'cli_id'),
            ],
            'phone' => 'nullable|string|max:20',
        ];
    }
}
