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
 * @property-read \App\News_i18n $one
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

    public function one()
    {
        return $this->belongsTo('App\News_i18n');
    }
}
