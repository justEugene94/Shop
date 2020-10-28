<?php


namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_phone
 * @property string $city
 * @property string $np_json
 */
class StoreFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "required|string|max:50|min:4",
            "last_name" => "required|string|max:50|min:4",
            "email" => "required|string|email",
            "mobile_phone" => "required|max:50|min:4|regex:/(38)[0-9]{10}/",
            "city" => "required|string|max:50|min:4",
            "np_json" => "required|json",
        ];
    }
}
