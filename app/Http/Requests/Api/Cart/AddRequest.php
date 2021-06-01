<?php


namespace App\Http\Requests\Api\Cart;


use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'qty' => 'integer',
            'rewrite' => 'bool'
        ];
    }

    /**
     * @return int
     */
    public function getCookieId(): int
    {
        return $this->input('cookie_id');
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->input('product_id');
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->input('qty', 1);
    }

    /**
     * @return bool
     */
    public function getRewrite(): bool
    {
        return $this->input('rewrite');
    }
}
