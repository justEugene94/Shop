<?php


namespace App\Http\Requests\Api\Order;


use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $cookie_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_phone
 * @property string $city
 * @property string $np_json
 */
class StoreRequest extends FormRequest
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
            "first_name" => "required|string|max:50|min:4",
            "last_name" => "required|string|max:50|min:4",
            "email" => "required|string|email",
            "mobile_phone" => "required|max:50|min:4|regex:/(38)[0-9]{10}/",
            "city" => "required|string|max:50|min:4",
            "np_json" => "required|json",
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
