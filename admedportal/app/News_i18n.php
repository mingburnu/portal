<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\News_i18n
 *
 * @property integer $news_id
 * @property integer $language
 * @property string $title
 * @property string $content
 * @property-read \App\News $news
 * @method static \Illuminate\Database\Query\Builder|\App\News_i18n whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News_i18n whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News_i18n whereContent($value)
 * @mixin \Eloquent
 */
class News_i18n extends Model
{
    //
    protected $table = 'news_i18n';

    protected $fillable;

    public $timestamps = false;

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);
    }

    public function news()
    {
        return $this->belongsTo('App\News', 'news_id');
    }
}
