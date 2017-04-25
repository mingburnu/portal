<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sort
 *
 * @property string $item
 * @property string $mode
 * @method static \Illuminate\Database\Query\Builder|\App\Sort whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sort whereMode($value)
 * @mixin \Eloquent
 */
class Sort extends Model
{
    //
    protected $table = 'sort';

    protected $fillable;

    protected $primaryKey = 'item';

    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);

    }
}
