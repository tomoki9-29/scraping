<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use \DOMDocument;
use \DOMXpath;

class smallIndustries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'small:industries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $datas = "SELECT large_industries_id, small_industries_id FROM small_industries";
        //var_dump($datas);
        $datas = DB::select($datas);
        //var_dump($datas);

        $array = [];
        foreach ($datas as $data) {
            $K = $data->large_industries_id;
            //var_dump($K);

            $k = $data->small_industries_id;
            //var_dump($k);

            $array += array($k => $K);
        }
        //var_dump($array);

        function region_data($tests, $large_industries_id, $small_industries_id)
        {

            $merge_datas = [];

            //var_dump($large_industries_ids);

            foreach ($tests as $test) {

                //var_dump($large_industries_ids);

                //会社IDの取得
                $link = $test->getAttribute('href');
                //echo $link. "\n";
                // 2018/company/r333400057/

                //$linkの必要な箇所だけ取得
                $paths = explode("/", $link);
                //print $paths[3]. "\n";

                //会社IDの配列化
                $company_id = array("company_id" => "001".$paths[3]);
                //var_dump($company_id);

                //サイトIDの配列化
                $employment_site_id = array("employment_site_id" => "001");
                //var_dump($siteID);

                //地域IDの配列化
                $large_industries_ids = array("large_industries_id" => "{$large_industries_id}");
                //var_dump($large_industries_id);

                //ロケーションIDの配列化
                $small_industries_ids = array("small_industries_id" => "{$small_industries_id}");
                //var_dump($large_industries_id);

                //会社ID,サイトID,大業種IDをマージ
                $merge_data = array_merge($company_id, $large_industries_ids, $small_industries_ids, $employment_site_id);

                //１ページ分の会社データ取得
                $merge_datas[] = $merge_data;
                //var_dump($merge_datas);

            }

            //配列の先頭を削除（重複しているため不要）
            //$fruit = array_shift($merge_datas);
            //var_dump($merge_datas);

            return $merge_datas;
        }

        //年月日時分秒の設定
        date_default_timezone_set('Asia/Tokyo');
        $today = date("YmdHis");

        $result = [];
        $result2 = [];

        //$cal = 0;

        //全ての大業種のクエリを回し、一つの大業種に注目
        foreach ($array as $small_industries_id => $large_industries_id) {

            //var_dump($large_industries_id);//全小業種クエリ確認

            //大業種のURL
            $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2&b=" . $small_industries_id . "&ms=0";
            //echo $url. "\n"; //全URL確認

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            @$dom->loadHTMLFile($url);
            $xpath = new DOMXPath($dom);

            //取得件数の計算
            $tests = $xpath->query('//span[@class="search-resultCounter-count"]')->item(0)->nodeValue;
            //$cal = $cal + $tests;
            //print $cal . "\n"; //合計件数の確認も済み

            //ページ数の計算
            $p = $tests / 100;
            //print $p . "\n";

            //1つの地域のURLの全ページを取得
            for ($i = 1; $i <= $p+1; $i++) {

                //大業種のURLの一つのページを取得
                $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2&b=" . $small_industries_id . "&ms=0&pn=" . $i;
                //echo $url. "\n"; //URL全ページ確認

                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                @$dom->loadHTMLFile($url);
                $xpath = new DOMXPath($dom);

                $tests = $xpath->query('//div[@class="search-cassette-title"]/a');

                //会社データの取得関数の呼び出し
                $merge_datas = region_data($tests, $large_industries_id, $small_industries_id);
                //print $merge_datas. "\n";

                //重複する各ページの広告PRの会社データを削除
                if (isset($xpath->query('//span[@class="search-cassette-prLabel"]')->item(0)->nodeValue) === false) {
                    //echo "PRなし". "\n";
                } else {
                    $delete = array_shift($merge_datas);
                    //var_dump($delete);
                }

                //全ページ分の会社データを1つの配列にまとめる
                $result = array_merge($result, $merge_datas);
                //var_dump($result);

            }

            //すべての地域の会社データを統合
            $result2 = array_merge($result2, $result);
            $result = [];

        }

        //var_dump($result2);

        $f = fopen("${today}smallIndustries.csv", "w");
        stream_filter_prepend($f, 'convert.iconv.utf-8/cp932');
        // 正常にファイルを開くことができていれば、書き込みます。
        if ($f) {
            // $ary から順番に配列を呼び出して書き込みます。
            foreach ($result2 as $line) {
                //var_dump($line);
                // fputcsv関数でファイルに書き込みます。
                fputcsv($f, $line);
            }
        }
        // ファイルを閉じます。
        fclose($f);

        // スクレイピングできた結果を登録する
        foreach($result2 as $line){
            //var_dump($line[""]);

            // 会社テーブルにデータを追加
            DB::table('companies_small_industries')->insert(
                [
                    'company_id' => $line["company_id"],
                    'large_industries_id' => $line["large_industries_id"],
                    'small_industries_id' => $line["small_industries_id"],
                    'employment_site_id' => $line["employment_site_id"],
                    'created_at'   => date("Y-m-d H:i:s"),
                    'updated_at'   => date("Y-m-d H:i:s")
                ]
            );
        }

    }
}
