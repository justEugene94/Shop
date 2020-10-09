<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
}
