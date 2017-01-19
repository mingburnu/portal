<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Book_i18n
 *
 * @property integer $book_id
 * @property integer $language
 * @property string $book_name
 * @property-read \App\Book $one
 * @method static \Illuminate\Database\Query\Builder|\App\Book_i18n whereBookId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book_i18n whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book_i18n whereBookName($value)
 * @mixin \Eloquent
 */
class Book_i18n extends Model
{
    //
    protected $table = 'book_i18n';

    public function one()
    {
        return $this->belongsTo('App\Book','book_id');
    }
}
