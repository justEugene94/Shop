<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
 * @property int $stripe_customer_id
 */
class Customer extends Model
{
    /** @var string */
    protected $table = 'customers';

    /** @var array  */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'stripe_customer_id',
    ];
}