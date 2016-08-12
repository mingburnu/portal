<?php

use Illuminate\Database\Seeder;

class querydatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('querydatabase')->truncate();

        DB::table('querydatabase')->insert([
            'database_name' => '館藏目錄',
            'syntax'=> '<form action="http://koha.sydt.com.tw/cgi-bin/koha/opac-search.pl" id="searchform" method="get" name="searchform" target="new">
<input id="transl1" name="q" type="text" />
<select id="masthead_search" name="idx">
<option value="kw">Keyword</option>
<option value="ti">Title</option>
<option value="au">Author</option>
<option value="su">Subject</option>
<option value="nb">ISBN</option>
<option value="se">Series</option>
<option value="callnum">Call Number</option>
</select>
<button type="submit">搜尋</button>
</form>',
            'view' => 1,
            'rank_id' => 1,
            'note' => '',
        ]);

        DB::table('querydatabase')->insert([
            'database_name' => 'PubMed 資料庫',
            'syntax' => '<form action="http://www.ncbi.nlm.nih.gov/entrez/query.fcgi" method="get" target="new">
<input name="db" type="hidden" value="PubMed" />
<input name="holding" type="hidden" value="wiuwqolib" />
<input name="term" type="TEXT" value="" />
<button type="submit">搜尋</button>
</form>',
            'view' => '1',
            'rank_id' => '2',
            'note' => '',
        ]);

        DB::table('querydatabase')->insert([
            'database_name' => '國家圖書館',
            'syntax' => '',
            'view' => '0',
            'rank_id' => '3',
            'note' => '資料庫停用',
        ]);

        DB::table('querydatabase')->insert([
            'database_name' => 'MedlinePlus 資料庫',
            'syntax' => '<form action="//www.nlm.nih.gov/search/medlineplus" method="get" target="new" title="MedlinePlus Search input">
<input id="medlineplus" maxlength="250" name="query" type="text" />
<button type="submit">搜尋</button>
</form>',
            'view' => '1',
            'rank_id' => '4',
            'note' => '',
        ]);

        DB::table('querydatabase')->insert([
            'database_name' => '考科藍實證醫學資料庫',
            'syntax' => '<form accept-charset="UTF-8" action="http://www.cochrane.org/zh-hant/evidence" class="search-form" id="search-form" method="post" target="new">
<div>
<div class="container-inline form-wrapper" id="edit-basic--2">
<div class="form-item form-type-textfield form-item-keys">
<input autocomplete="off" id="edit-keys--2" maxlength="255" name="keys" type="text" value="" />
<button type="submit">搜尋</button>
<input name="get" type="hidden" value="[]" /></div>
<input name="form_build_id" type="hidden" value="form-IauDU3e6e4asRIW4wmOwEfYl73ux_ID6dRl48etEAq4" />
<input name="form_id" type="hidden" value="apachesolr_search_custom_page_search_form" />
</div>
</div>
</form>',
            'view' => '1',
            'rank_id' => '5',
            'note' => '',
        ]);

    }

}
