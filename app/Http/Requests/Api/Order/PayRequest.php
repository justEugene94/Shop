<?php


namespace App\Http\Requests\Api\Order;


use Illuminate\Foundation\Http\FormRequest;


class PayRequest extends FormRequest
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
            'token' => 'required|string',
        ];
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->input('token');
    }
}
