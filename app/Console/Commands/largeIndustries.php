<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use \DOMDocument;
use \DOMXpath;

class largeIndustries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'large:industries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create LargeIndustriesTable';

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
        //大業種IDをDBから取得し配列化
        $datas = DB::select("SELECT large_industries_id FROM large_industries");
        foreach ($datas as $data) {
            $large_industries_ids[] = $data->large_industries_id;
        }
        //var_dump($large_industries_ids);

        $query_array = [];
        //DBから大業種検索クエリを作成して配列化
        foreach ($large_industries_ids as $result) {

            $large_id = $result;
            $datas = "SELECT small_industries_id FROM small_industries WHERE large_industries_id =\"" . $large_id . "\"" . "\n";
            //echo $datas;
            $datas = DB::select($datas);
            //var_dump($datas);

            $query = "";
            foreach ($datas as $data) {
                //var_dump((array)$data);
                //exit;

                $b = $data->small_industries_id;
                $query = $query . "&b=" . $b;
            }
            $query_array[] = $query;
        }
        //var_dump($query_array);

        //年月日時分秒の設定
        date_default_timezone_set('Asia/Tokyo');
        $today = date("YmdHis");

        $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2&b=8&b=9&b=10&b=7&b=32&b=31&b=33&b=14&b=15&b=11&b=13&b=16&b=21&b=20&b=12&b=18&b=19&b=17&b=22&b=3&b=4&b=6&b=5&b=30&b=29&b=27&b=28&b=23&b=25&b=26&b=24&b=2&b=1&b=34&ms=0";

        $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";

        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadHTMLFile($url);
        $xpath = new DOMXPath($dom);

        //件数の取得
        $tests = $xpath->query('//span[@class="search-resultCounter-count"]')->item(0)->nodeValue;

        //ページ数の計算
        $p = $tests/100;
        //print $p . "\n";*/

        function company_data($tests,$large_industries_ids){

            $merge_datas = [];

            //var_dump($large_industries_ids);

            foreach($tests as $test){

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

                //大業種IDの配列化
                $large_industries_id = array("large_industries_id" => "{$large_industries_ids}");
                //var_dump($large_industries_id);

                //会社ID,サイトID,大業種IDをマージ
                $merge_data = array_merge($company_id, $large_industries_id, $employment_site_id);

                //１ページ分の会社データ取得
                $merge_datas[] = $merge_data;
                //var_dump($merge_datas);

            }

            //配列の先頭を削除（重複しているため不要）
            //$fruit = array_shift($merge_datas);
            //var_dump($merge_datas);

            return $merge_datas;
        }

        $csv_header = ["会社名","資本金","売上高","代表者","ホームページ","メールアドレス","連絡先"];
        $result = [];
        $result2 = [];

        //大業種クエリと大業種IDの連想配列を作成する
        $query_id = array_combine($query_array, $large_industries_ids);
        //var_dump($query_id);

            //全ての大業種のクエリを回し、一つの大業種に注目
            foreach ($query_array as $query_url) {

                //var_dump($query_url); 全クエリ確認

                //大業種IDの取得
                $large_industries_ids = $query_id[$query_url];
                //echo $large_industries_ids; 全大業種ID確認

                //大業種のURL取得
                $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2" . $query_url . "&ms=0";
                echo $url. "\n"; //全URL確認

                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                @$dom->loadHTMLFile($url);
                $xpath = new DOMXPath($dom);

                //取得件数の計算
                $tests = $xpath->query('//span[@class="search-resultCounter-count"]')->item(0)->nodeValue;
                //print $tests . "\n";

                //ページ数の計算
                $p = $tests/100;
                //print $p . "\n";

                //大業種のURLの全ページを取得
                for($i=1;$i<=$p+1;$i++) {

                    //大業種のURLの一つのページを取得
                    $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2" . $query_url . "&ms=0&pn=" .$i;
                    //echo $url. "\n"; //URL全ページ確認

                    $dom = new DOMDocument;
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    @$dom->loadHTMLFile($url);
                    $xpath = new DOMXPath($dom);

                    $tests = $xpath->query('//div[@class="search-cassette-title"]/a');

                    //会社データの取得関数の呼び出し
                    $merge_datas = company_data($tests, $large_industries_ids);
                    //print $merge_datas. "\n";

                    //重複する各ページの広告PRの会社データを削除
                    if (isset($xpath->query('//span[@class="search-cassette-prLabel"]')->item(0)->nodeValue)  === false) {
                        //echo "PRなし". "\n";
                    } else {
                        $delete = array_shift($merge_datas);
                        //var_dump($delete);
                    }

                    //全ページ分の会社データを1つの配列にまとめる
                    $result = array_merge($result, $merge_datas);
                    //var_dump($result);

                }

                //すべての大業種の会社データを統合
                $result2 = array_merge($result2, $result);
                $result = [];

            }

        //var_dump($result2);

        $f = fopen("${today}largeIndustries.csv", "w");
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
            DB::table('companies_large_industries')->insert(
                [
                    'company_id' => $line["company_id"],
                    'large_industries_id' => $line["large_industries_id"],
                    'employment_site_id' => $line["employment_site_id"],
                    'created_at'   => date("Y-m-d H:i:s"),
                    'updated_at'   => date("Y-m-d H:i:s")
                ]
            );
        }

    }



}
