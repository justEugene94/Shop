<?php


namespace App\Http\Requests\Api\Cart;


use Illuminate\Foundation\Http\FormRequest;

class ClearRequest extends FormRequest
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
            'cookie_id' => 'required|string|max:800',
        ];
    }

    /**
     * @return string
     */
    public function getCookieId(): string
    {
        return $this->input('cookie_id');
    }
}
