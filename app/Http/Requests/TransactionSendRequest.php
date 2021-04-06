<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TransactionSendRequest
 *
 * @package App\Http\Requests
 */
class TransactionSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'payer_id' => 'required',
            'payee_id' => 'required',
            'value' => 'required|numeric|min:0.1',
        ];
    }

    public function messages(): array
    {
        return [
            'payer_id' => 'A payer is required',
            'payee_id' => 'A payee is required',
            'value' => 'A value is required',
        ];
    }
}
