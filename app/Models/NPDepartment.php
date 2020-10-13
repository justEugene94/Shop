<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NPDepartment extends Model
{
    /** @var string  */
    protected $table = 'np_departments';

    /** @var array */
    protected $fillable = [
        'np_id',
        'department',
    ];

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_np_department', 'np_department_id', 'customer_id');
    }
}
