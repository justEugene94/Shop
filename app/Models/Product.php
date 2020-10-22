<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $quantity
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
}
