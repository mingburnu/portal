<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Db_i18n
 *
 * @property integer $id
 * @property integer $db_id
 * @property integer $language
 * @property string $database_name
 * @property string $syntax
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereDbId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereDatabaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Db_i18n whereSyntax($value)
 * @mixin \Eloquent
 * @property-read \App\Db $one
 */
class Db_i18n extends Model
{
    //
    protected $table = 'querydatabase_i18n';

    public function one()
    {
        return $this->belongsTo('App\Db','db_id');
    }
}
