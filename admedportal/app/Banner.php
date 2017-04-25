<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Banner
 *
 * @property integer $id
 * @property string $title
 * @property integer $play
 * @property string $info
 * @property integer $upload_option
 * @property string $img
 * @property string $url
 * @property integer $view
 * @property integer $rank_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Banner_i18n[] $banner_i18ns
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner wherePlay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereUploadOption($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereRankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Banner extends Model
{
    //
    protected $table = 'banner';

    protected $fillable;

    protected $casts = [
        'play' => 'boolean',
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

    public function banner_i18ns()
    {
        return $this->hasMany('App\Banner_i18n', 'banner_id');
    }
}