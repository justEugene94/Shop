<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $np_id
 * @property string $name
 */
class City extends Model
{
    /** @var string  */
    protected $table = 'cities';

    /** @var array */
    protected $fillable = [
        'np_id',
        'name',
    ];

    /**
     * @return HasMany
     */
    public function npDepartments()
    {
        return $this->hasMany(NPDepartment::class, 'city_id', 'id');
    }
}
