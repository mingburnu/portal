<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Menupage
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $content
 * @property string $url
 * @property integer $view
 * @property integer $parent_id
 * @property integer $rank_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Menupage $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menupage[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menupage_i18n[] $many
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereRankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menupage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menupage extends Model
{
    //
    protected $table = 'pages';

    public function parent()
    {
        return $this->belongsTo('App\Menupage', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Menupage', 'parent_id');
    }

    public function many()
    {
        return $this->hasMany('App\Menupage_i18n');
    }
}
