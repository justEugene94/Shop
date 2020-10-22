<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $quantity
 *
 * Relations:
 * @property Order[] $orders
 */
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
    ];

    /**
     * @return BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot('qty');
    }
}
