<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\News
 *
 * @property integer $id
 * @property string $publish_time
 * @property string $title
 * @property string $content
 * @property integer $view
 * @property integer $rank_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\News_i18n[] $many
 * @method static \Illuminate\Database\Query\Builder|\App\News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News wherePublishTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereRankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class News extends Model
{
    //
    protected $table = 'news';

    public function many()
    {
        return $this->hasMany('App\News_i18n');
    }
}
