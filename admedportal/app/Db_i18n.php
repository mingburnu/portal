<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Db_i18n
 *
 * @property integer $db_id
 * @property integer $language
 * @property string $database_name
 * @property string $syntax
 * @property-read \App\Db $db
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereDbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereDatabaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereSyntax($value)
 * @mixin \Eloquent
 */
class Db_i18n extends Model
{
    //
    protected $table = 'querydatabase_i18n';

    protected $fillable;

    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);
    }

    public function db()
    {
        return $this->belongsTo('App\Db', 'db_id');
    }
}
