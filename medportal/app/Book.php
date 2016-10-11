<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Book
 *
 * @property integer $id
 * @property string $cover
 * @property integer $upload_option
 * @property string $book_name
 * @property string $book_name_ch
 * @property string $book_name_cn
 * @property string $book_name_en
 * @property string $book_name_jp
 * @property string $book_name_kr
 * @property string $url
 * @property integer $view
 * @property integer $rand_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book_i18n[] $many
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUploadOption($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookNameCh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookNameCn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookNameEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookNameJp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBookNameKr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereRandId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    //
    protected $table = 'book';

    public function many()
    {
        return $this->hasMany('App\Book_i18n');
    }
}
