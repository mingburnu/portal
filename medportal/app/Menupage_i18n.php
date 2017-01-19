<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Menupage_i18n
 *
 * @property integer $page_id
 * @property integer $language
 * @property string $title
 * @property string $content
 * @property string $url
 * @property-read \App\Menupage_i18n $one
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage_i18n wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage_i18n whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage_i18n whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage_i18n whereUrl($value)
 * @mixin \Eloquent
 */
class Menupage_i18n extends Model
{
    //
    protected $table = 'pages_i18n';

    public function one()
    {
        return $this->belongsTo('App\Menupage','page_id');
    }
}
