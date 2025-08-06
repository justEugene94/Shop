<?php


namespace App\Http\Requests\Api\Cart;


use App\Http\Requests\Api\CartRequest;

class AddRequest extends CartRequest
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
        $parentRules = parent::rules();

        return array_merge($parentRules, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'integer',
            'rewrite' => 'bool'
        ]);
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
        return $this->input('rewrite', false);
    }
}
