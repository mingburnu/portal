<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Banner_i18n
 *
 * @property integer $banner_id
 * @property integer $language
 * @property string $title
 * @property string $info
 * @property-read \App\Banner $banner
 * @method static \Illuminate\Database\Query\Builder|\App\Banner_i18n whereBannerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner_i18n whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner_i18n whereInfo($value)
 * @mixin \Eloquent
 */
class Banner_i18n extends Model
{
    //
    protected $table = 'banner_i18n';

    protected $fillable;

    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);
    }

    public function banner()
    {
        return $this->belongsTo('App\Banner', 'banner_id');
    }
}
