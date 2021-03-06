<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
 * @property int $stripe_customer_id
 *
 * Relationship:
 * @property NPDepartment[] $npDepartments
 * @property Order[] $orders
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

    /**
     * @return BelongsToMany
     */
    public function npDepartments()
    {
        return $this->belongsToMany(NPDepartment::class, 'customer_np_department', 'customer_id', 'np_department_id');
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
