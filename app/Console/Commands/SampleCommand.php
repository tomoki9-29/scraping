<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \DOMDocument;
use \DOMXpath;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        //都道府県の連想配列
        $pref = array("1" => "北海道", "2" => "青森県", "3" => "岩手県", "4" => "宮城県", "5" => "秋田県", "6" => "山形県", "7" => "福島県", "8" => "茨城県", "9" => "栃木県", "10" => "群馬県", "11" => "埼玉県", "12" => "千葉県", "13" => "東京都", "14" => "神奈川県", "15" => "新潟県", "16" => "富山県", "17" => "石川県", "18" => "福井県", "19" => "山梨県", "20" => "長野県", "21" => "岐阜県", "22" => "静岡県", "23" => "愛知県", "24" => "三重県", "25" => "滋賀県", "26" => "京都府", "27" => "大阪府", "28" => "兵庫県", "29" => "奈良県", "30" => "和歌山県", "31" => "鳥取県", "32" => "島根県", "33" => "岡山県", "34" => "広島県", "35" => "山口県", "36" => "徳島県", "37" => "香川県", "38" => "愛媛県", "39" => "高知県", "40" => "福岡県", "41" => "佐賀県", "42" => "長崎県", "43" => "熊本県", "44" => "大分県", "45" => "宮崎県", "46" => "鹿児島県", "47" => "沖縄県");

        //業種・職種・勤務地の条件を指定して件数を絞り込む
        $b = 86;   //業種
        $j = 24;   //職種
        $k = 27;   //勤務地

        //年月日時分秒の設定
        date_default_timezone_set('Asia/Tokyo');
        $today = date("YmdHis");

        $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2&b=83&b=81&b=80&b=82&b=84&b=55&b=56&b=57&b=58&b=59&b=62&b=60&b=65&b=61&b=63&b=64&b=66&b=67&ms=0";

        $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";

        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadHTMLFile($url);
        $xpath = new DOMXPath($dom);

        //件数の取得
        $tests = $xpath->query('//span[@class="search-resultCounter-count"]')->item(0)->nodeValue;

        //ページ数の計算
        $p = $tests / 100;
        //print $p . "\n";


        $csv_header = ["会社名", "資本金", "売上高", "代表者", "ホームページ", "メールアドレス", "連絡先"];

        //csv出力前に、表示されるファイルパス、集計件数、条件内容
        $output_result = "条件：業界(b={$b})、職種(j={$j})、勤務地({$pref[$k]})、会社件数：{$tests}件";
        echo $output_result;
        $output_result = "ファイルパス：C:\Users\admin44\Downloads\{$today}.csv" . "\n";
        $output_result = preg_replace("/({)/", "", $output_result);
        $output_result = preg_replace("/(})/", "", $output_result);
        echo $output_result;

        //会社一覧ページ毎
        for ($i = 1; $i <= $p + 1; $i++) {

            $url = "https://job.rikunabi.com/2018/search/company/result/?isc=r8rcna01262&moduleCd=2&b=83&b=81&b=80&b=82&b=84&b=55&b=56&b=57&b=58&b=59&b=62&b=60&b=65&b=61&b=63&b=64&b=66&b=67&ms=0&pn=" . $i;
            //print $url . "\n";

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            @$dom->loadHTMLFile($url);
            $xpath = new DOMXPath($dom);

            $tests = $xpath->query('//div[@class="search-cassette-title"]/a');

            foreach ($tests as $test) {
                $link = $test->getAttribute('href');

                $link = "https://job.rikunabi.com" . $link;


                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                @$dom->loadHTMLFile($link);
                $xpath = new DOMXPath($dom);

                // 会社名の取得
                $companys = trim($xpath->query('//h1[@class="ts-h-company-mainTitle"]')->item(0)->nodeValue);
                $company1 = array("会社名" => $companys);
                $company1 = str_replace(array(" "), '', $company1);
                //print_r($company1);

                //会社データのラベルの取得
                $header = $xpath->query('//tr/th[@class="ts-h-mod-dataTable02-cell ts-h-mod-dataTable02-cell_th"]');

                //会社データの値の取得
                $value = $xpath->query('//tr/td[@class="ts-h-mod-dataTable02-cell ts-h-mod-dataTable02-cell_td"]');

                $keys = [];
                $vals = [];

                foreach ($header as $node) {
                    $key = trim($node->nodeValue);
                    $keys[] = htmlspecialchars($key);
                }

                foreach ($value as $node) {
                    $val = trim($node->nodeValue);
                    $vals[] = htmlspecialchars($val);
                }

                $array = array_combine($keys, $vals);
                $array = str_replace(array("\r\n", "\r", "\n","■", " "), '', $array);

                //連絡先の取得
                $address = trim($xpath->query('//*[@id="company-data04"]/div[@class="ts-h-company-sentence"]')->item(0)->nodeValue);

                //連絡先の改行削除
                $address = str_replace(array("\r\n", "\r", "\n","■", " "), '', $address);

                $address = array("連絡先" => $address);

                //連絡先の再取得
                $address2 = trim($xpath->query('//*[@id="company-data04"]/div[@class="ts-h-company-sentence"]')->item(0)->nodeValue);
                //連絡先の改行削除
                $address2 = str_replace(array("\r\n", "\r", "\n", " "), '', $address2);

                //連絡先から企業URLを取得する。
                preg_match('/(http|https)(：|:)(.*?)(.jp|.com)/', $address2, $match);
                $match[0] = (isset($match[0])) ? $match[0] : '';
                $url = $match[0];

                $company_url = (isset($array["ホームページ"])) ? $array["ホームページ"] : '';
                if ($company_url == "") {
                    $array["ホームページ"] = $url;
                }

                //連絡先からメールアドレスを取得する。
                preg_match('/(mail|E－mail|Ｅ-ｍａｉｌ|e-mail|Mail|MAIL|メール|E-MAIL|ＭＡＩＬ|ｍａｉｌ|アドレス|Maiｌ)( |　|：|:|: | :|】|／|…)(.*?)(.jp|.com)/', $address2, $match);
                $match[3] = (isset($match[3])) ? $match[3] : '';
                $match[4] = (isset($match[4])) ? $match[4] : '';
                $email = $match[3] . $match[4];

                $email = preg_replace("/( |　|:|：|〇)/", "", $email);
                $email = preg_replace("/(☆)/", "@", $email);
                //echo $email;

                if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    $email = "";
                }

                $address_array = array("メールアドレス" => $email);

                $company = array_merge($array, $address_array);
                $company = array_merge($company, $address);
                $company = array_merge($company1, $company);
                //var_dump($company);

                $_company = [];
                foreach ($csv_header as $column_name) {

                    $_company[$column_name] = (isset($company[$column_name])) ? $company[$column_name] : '';

                }

                $_company["売上高"] = str_replace(",", "", $_company["売上高"]);
                $_company["資本金"] = str_replace(",", "", $_company["資本金"]);

                $company = $_company;
                //var_dump($company);
                $companies[] = $company;
                //var_dump($companies);
                $result = [];
            }
            $result = $result + $companies;
        }
        array_unshift($result, $csv_header);
        print_r($result);

        $f = fopen("${today}.csv", "w");
        stream_filter_prepend($f, 'convert.iconv.utf-8/cp932');
        // 正常にファイルを開くことができていれば、書き込みます。
        if ($f) {
            // $ary から順番に配列を呼び出して書き込みます。
            foreach ($result as $line) {
                //var_dump($line);
                // fputcsv関数でファイルに書き込みます。
                fputcsv($f, $line);
            }
        }
        // ファイルを閉じます。
        fclose($f);
    }
}
