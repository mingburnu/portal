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
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereDatabaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereSyntax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereRankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Db_i18n[] $many
 */
class Db extends Model
{
    //
    protected $table = 'querydatabase';

    public function many()
    {
        return $this->hasMany('App\Db_i18n','db_id');
    }
}
