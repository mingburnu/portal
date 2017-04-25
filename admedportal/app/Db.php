<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Db
 *
 * @property integer $id
 * @property string $database_name
 * @property string $syntax
 * @property integer $view
 * @property integer $rank_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Db_i18n[] $db_i18ns
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereDatabaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereSyntax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereRankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Db extends Model
{
    //
    protected $table = 'querydatabase';

    protected $fillable;

    protected $casts = [
        'view' => 'boolean'
    ];

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);

    }

    public function db_i18ns()
    {
        return $this->hasMany('App\Db_i18n', 'db_id');
    }
}
