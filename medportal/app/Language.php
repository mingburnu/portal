<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Language
 *
 * @property integer $id
 * @property string $language
 * @property string $name
 * @property boolean $display
 * @property integer $sort
 * @property string $home
 * @property string $location
 * @property string $query
 * @property string $newest
 * @property string $more
 * @property string $visitor
 * @property string $board
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereHome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereQuery($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereNewest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereMore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereVisitor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereBoard($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    //
    protected $table = 'languages';

    protected $fillable;

    public $timestamps = false;

    protected $casts = [
        'display' => 'boolean'
    ];

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);

    }
}
