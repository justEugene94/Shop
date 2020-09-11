<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $quantity
 */
class Goods extends Model
{
    protected $table = 'goods';

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
    ];
}
