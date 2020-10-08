<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @var string */
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'stripe_customer_id',
    ];
}
