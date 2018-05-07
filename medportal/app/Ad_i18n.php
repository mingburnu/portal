<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ad_i18n
 *
 * @mixin \Eloquent
 * @property integer $ad_id
 * @property integer $language
 * @property string $title
 * @property-read \App\Ad $ad
 * @method static \Illuminate\Database\Query\Builder|\App\Ad_i18n whereAdId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad_i18n whereTitle($value)
 */
class Ad_i18n extends Model
{
    //
    protected $table = 'ad_i18n';

    protected $fillable;

    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad', 'ad_id');
    }
}
