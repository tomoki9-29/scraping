@extends('layouts.app')

@section('content')

    <!-- ここにページ毎のコンテンツを書く -->
    <?php
    //都道府県の連想配列
        $pref = array("1" => "北海道", "2" => "青森県", "3" => "岩手県", "4" => "宮城県", "5" => "秋田県", "6" => "山形県", "7" => "福島県", "8" => "茨城県", "9" => "栃木県", "10" => "群馬県", "11" => "埼玉県", "12" => "千葉県", "13" => "東京都", "14" => "神奈川県", "15" => "新潟県", "16" => "富山県", "17" => "石川県", "18" => "福井県", "19" => "山梨県", "20" => "長野県", "21" => "岐阜県", "22" => "静岡県", "23" => "愛知県", "24" => "三重県", "25" => "滋賀県", "26" => "京都府", "27" => "大阪府", "28" => "兵庫県", "29" => "奈良県", "30" => "和歌山県", "31" => "鳥取県", "32" => "島根県", "33" => "岡山県", "34" => "広島県", "35" => "山口県", "36" => "徳島県", "37" => "香川県", "38" => "愛媛県", "39" => "高知県", "40" => "福岡県", "41" => "佐賀県", "42" => "長崎県", "43" => "熊本県", "44" => "大分県", "45" => "宮崎県", "46" => "鹿児島県", "47" => "沖縄県");

        //業種・職種・勤務地の条件を指定して件数を絞り込む
        $b = 86;   //業種
        $j = 24;   //職種
        $k = 27;   //勤務地

        //年月日時分秒の設定
        date_default_timezone_set('Asia/Tokyo');
        $today = date("YmdHis");

        $url = "https://job.rikunabi.com/2018/search/company/result/?b=" . $b . "&j=" . $j . "&k=" .$k;

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


        $csv_header = ["会社名", "代表者", "ホームページ", "メールアドレス", "電話番号", "資本金", "売上高", "連絡先"];

        //csv出力前に、表示されるファイルパス、集計件数、条件内容
        $output_result = "条件：業界(b={$b})、職種(j={$j})、勤務地({$pref[$k]})、会社件数：{$tests}件";
        echo $output_result;
        $output_result = "ファイルパス：C:\Users\admin44\Downloads\{$today}.csv" . "\n";
        $output_result = preg_replace("/({)/", "", $output_result);
        $output_result = preg_replace("/(})/", "", $output_result);
        echo $output_result;
    ?>

    {{ Form::select('pref_id',$rikunavis, null, ['class' => 'form', 'id' => 'pref_id']) }}<br>

    <p>
        <a href="/csv"><input type="button" value="CSV出力">
    </p>

@endsection