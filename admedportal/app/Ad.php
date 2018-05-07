<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ad
 *
 * @property integer $id
 * @property string $title
 * @property integer $upload_option
 * @property string $img
 * @property string $url
 * @property string $publish_time
 * @property string $end_time
 * @property integer $view
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ad_i18n[] $ad_i18ns
 * @property string publish_day
 * @property string publish_hh
 * @property string publish_ii
 * @property string publish_ss
 * @property bool forever
 * @property string end_day
 * @property string end_hh
 * @property string end_ii
 * @property string end_ss
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereUploadOption($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad wherePublishTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ad whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ad extends Model
{
    //
    protected $table = 'ad';

    protected $fillable;

    protected $casts = [
        'upload_option' => 'boolean',
        'view' => 'boolean'
    ];

    function __construct(array $attributes = [])
    {
        $this->fillable(\Schema::getColumnListing($this->getTable()));

        $this->bootIfNotBooted();

        $this->syncOriginal();

        $this->fill($attributes);

    }

    public function ad_i18ns()
    {
        return $this->hasMany('App\Ad_i18n', 'ad_id');
    }
}
