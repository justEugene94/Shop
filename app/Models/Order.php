<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property array $statuses
 * @property int $id
 * @property string $stripe_order_id
 * @property float $amount
 * @property int $status_id
 * @property string $info
 *
 * Relationships:
 * @property Customer $customer
 * @property NPDepartment $npDepartment
 * @property Status $status
 * @property Product[] $products
 */
class Order extends Model
{
    const CURRENCY = 'UAH';

    /** Array with statuses
     * @key is a local status
     * @value is a stripe status
     */
    public $statuses = [
        'created' => 'created',
        'paid' => 'paid',
        'fulfilled' => 'fulfilled',
        'error' => 'canceled'
    ];

    /** @var string */
    protected $table = 'orders';

    /** @var array */
    protected $fillable = [
        'stripe_order_id',
        'amount',
        'status_id',
        'info'
    ];

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function npDepartment()
    {
        return $this->belongsTo(NPDepartment::class, 'np_department_id', 'id');
    }

    /**
     * @return Status
     */
    public function getStatusAttribute()
    {
        return (new Status)->find($this->status_id);
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
                    ->withPivot('qty');
    }
}
