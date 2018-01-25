<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use app\Library;

class EmploymentSitesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // ----------------------------------------
        //  CSVファイルの読み込み処理
        // ----------------------------------------
        // CSVファイルのパスを取得
        $csvFilePath = base_path() . "/database/seedscsv/EmploymentSitesTableSeederCsv.csv";

        // CSVファイルの読み込み処理
        $csvReader = new CsvReader($csvFilePath);

        // CSVファイルのデータを配列に変換
        $csvArrayData = $csvReader->convertCsvToArray();

        // ----------------------------------------
        //  就職サイトテーブルにデータを追加
        // ----------------------------------------
        // CSVデータ数分（CSVファイルの行数分）繰り返す
        foreach($csvArrayData as $csvArrayLineData){
                
            DB::table('employment_sites')->insert([
                'employment_site_id' => $csvArrayLineData[0],
                'site_name'          => $csvArrayLineData[1],
                'created_at'         => date("Y-m-d H:i:s"),
                'updated_at'         => date("Y-m-d H:i:s")
            ]);
        
        }

    }

}
