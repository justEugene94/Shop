<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property int $cookie_id
 * @property int $qty
 *
 * Relations:
 * @property Product $product
 */
class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'product_id',
        'cookie_id',
        'qty'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
