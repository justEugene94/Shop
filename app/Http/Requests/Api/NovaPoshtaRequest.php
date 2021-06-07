<?php


namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;


abstract class NovaPoshtaRequest extends FormRequest
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
            'city' => 'required|string|max:50',
        ];
    }

    public function getCity(): string
    {
        return $this->input('city');
    }
}
