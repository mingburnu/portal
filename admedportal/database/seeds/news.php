<?php

use Illuminate\Database\Seeder;

class news extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('news')->truncate();

        DB::table('news')->insert([
            'title' => '一起為生命畫個圓',
            'content' => '一起為生命畫個圓',
            'view' => '1',
            'rank_id' => '1',
            'note' => '',
            'created_at' => '2015-06-03 12:00:00',
            'publish_time' => '2015-06-03',
        ]);

        DB::table('news')->insert([
            'title' => '[公開徵信]截至104.6.1下午4時，本部賑災專戶經收「尼泊爾地震賑災」計新臺幣8,822萬7,520元整。',
            'content' => '[公開徵信]截至104.6.1下午4時，本部賑災專戶經收「尼泊爾地震賑災」計新臺幣8,822萬7,520元整。',
            'view' => '1',
            'rank_id' => '2',
            'note' => '',
            'created_at' => '2015-06-02 12:00:00',
            'publish_time' => '2015-06-02',
        ]);

        DB::table('news')->insert([
            'title' => '醫院品質績效量測指標系統與落實品質改善第二階段計畫',
            'content' => '醫院品質績效量測指標系統與落實品質改善第二階段計畫',
            'view' => '1',
            'rank_id' => '3',
            'note' => '',
            'created_at' => '2015-05-28 12:00:00',
            'publish_time' => '2015-05-28',
        ]);
        

        DB::table('news')->insert([
            'title' => '104年度精神護理之家評鑑作業程序',
            'content' => '104年度精神護理之家評鑑作業程序',
            'view' => '1',
            'rank_id' => '4',
            'note' => '',
            'created_at' => '2015-05-22 12:00:00',
            'publish_time' => '2015-05-22',
        ]);

        DB::table('news')->insert([
            'title' => '公告104年度心理健康促進與衛生教育計畫',
            'content' => '公告104年度心理健康促進與衛生教育計畫',
            'view' => '1',
            'rank_id' => '5',
            'note' => '',
            'created_at' => '2015-05-21 12:00:00',
            'publish_time' => '2015-05-21',
        ]);

        DB::table('news')->insert([
            'title' => '聽，山海在召喚！',
            'content' => '聽，山海在召喚！',
            'view' => '1',
            'rank_id' => '6',
            'note' => '',
            'created_at' => '2015-05-20 12:00:00',
            'publish_time' => '2015-05-20',
        ]);

        DB::table('news')->insert([
            'title' => '「全國社工日表揚績優社會工作人員獎項名稱、獎座樣式及社會工作專業識別圖案(LOGO)設計比賽計畫」活動辦法',
            'content' => '「全國社工日表揚績優社會工作人員獎項名稱、獎座樣式及社會工作專業識別圖案(LOGO)設計比賽計畫」活動辦法',
            'view' => '1',
            'rank_id' => '7',
            'note' => '',
            'created_at' => '2015-05-19 12:00:00',
            'publish_time' => '2015-05-19',
        ]);

        DB::table('news')->insert([
            'title' => '中華民國第18屆身心障礙楷模金鷹獎，開始選拔！',
            'content' => '中華民國第18屆身心障礙楷模金鷹獎，開始選拔！',
            'view' => '1',
            'rank_id' => '8',
            'note' => '',
            'created_at' => '2015-05-17 12:00:00',
            'publish_time' => '2015-05-17',
        ]);

        DB::table('news')->insert([
            'title' => '樂生青年聯盟陳情訴求「0617衛福部行動！官方只管收租金 放任劇組傷古蹟」一事，澄清說明如下：',
            'content' => '樂生青年聯盟陳情訴求「0617衛福部行動！官方只管收租金 放任劇組傷古蹟」一事，澄清說明如下：',
            'view' => '1',
            'rank_id' => '9',
            'note' => '',
            'created_at' => '2015-05-14 12:00:00',
            'publish_time' => '2015-05-14',
        ]);

        DB::table('news')->insert([
            'title' => '澄清104/3/26中國時報「藥品大掃黑 食品GMP廠也破功」報導',
            'content' => '澄清104/3/26中國時報「藥品大掃黑 食品GMP廠也破功」報導',
            'view' => '1',
            'rank_id' => '10',
            'note' => '',
            'created_at' => '2015-05-12 12:00:00',
            'publish_time' => '2015-05-12',
        ]);

        DB::table('news')->insert([
            'title' => '食品藥物管理署聲明，經查無北美祥茂公司申請國產氣墊床查驗登記紀錄，有關壹週刊638期報導該公司申請氣墊床乙節，實與事實不符。',
            'content' => '食品藥物管理署聲明，經查無北美祥茂公司申請國產氣墊床查驗登記紀錄，有關壹週刊638期報導該公司申請氣墊床乙節，實與事實不符。',
            'view' => '1',
            'rank_id' => '11',
            'note' => '',
            'created_at' => '2015-05-11 12:00:00',
            'publish_time' => '2015-05-11',
        ]);

        DB::table('news')->insert([
            'title' => '恆富企業有限公司回收所有批號之「"菲尼斯"肝燐脂注射液1000單位/毫升 HEPARIN SODIUM-FRESENIUS INJECTION 1000IU/ML (衛署藥輸字第022827號)」藥品',
            'content' => '恆富企業有限公司回收所有批號之「"菲尼斯"肝燐脂注射液1000單位/毫升 HEPARIN SODIUM-FRESENIUS INJECTION 1000IU/ML (衛署藥輸字第022827號)」藥品',
            'view' => '1',
            'rank_id' => '12',
            'note' => '',
            'created_at' => '2015-05-10 12:00:00',
            'publish_time' => '2015-05-10',
        ]);


        DB::table('news')->insert([
            'title' => '舉辦103年度「藥物科技研究發展獎」頒獎典禮',
            'content' => '舉辦103年度「藥物科技研究發展獎」頒獎典禮',
            'view' => '1',
            'rank_id' => '13',
            'note' => '',
            'created_at' => '2015-05-10 09:00:00',
            'publish_time' => '2015-05-10',
        ]);

    }
}
