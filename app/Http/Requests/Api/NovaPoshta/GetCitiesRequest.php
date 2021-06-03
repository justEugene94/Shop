<?php


namespace App\Http\Requests\Api\NovaPoshta;


use App\Http\Requests\Api\NovaPoshtaRequest;


class GetCitiesRequest extends NovaPoshtaRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
