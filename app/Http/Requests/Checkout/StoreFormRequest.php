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
 * @property string $cc_name
 * @property string $cc_number
 * @property string $cc_exp_month
 * @property string $cc_exp_year
 * @property string $cc_ccv
 *
 * @property array $getCard
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
            "cc_name" => "required|string",
            "cc_number" => "required|string|regex:/[0-9]{16}/",
            "cc_exp_month" => "required|string||regex:/[0-9]{2}/",
            "cc_exp_year" => "required|string||regex:/[0-9]{4}/",
            "cc_ccv" => "required|string|regex:/[0-9]{3}/",
        ];
    }

    public function getCard()
    {
        return [
            'number' => $this->input('cc_number'),
            'exp_month' => $this->input('cc_exp_month'),
            'exp_year' => $this->input('cc_exp_year'),
            'cvc' => $this->input('cc_ccv'),
        ];
    }
}
