<?php
/**
 * Created by PhpStorm.
 * User: roderick
 * Date: 2017/1/23
 * Time: 下午 04:51
 */
$title_i18n = $news[$i]->title;
$i18n = \App\News_i18n::where('news_id', $news[$i]->id)->where('language', Cookie::get('language'))->get();
if (sizeof($i18n) != 0 && $i18n[0]->title != null) {
    $title_i18n = $i18n[0]->title;
}

?>
@foreach($news[$i]['many'] as $news_i18n)
    <?php
    if ($news_i18n->language == Cookie::get('language') && $news_i18n->title != null) {
        $title_i18n = $news_i18n->title;
    }
    ?>
@endforeach
