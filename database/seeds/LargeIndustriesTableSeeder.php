<?php

use Illuminate\Database\Seeder;

class LargeIndustriesTableSeeder extends Seeder
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
        $csvFilePath = base_path() . "/database/seedscsv/LargeIndustriesTableSeederCsv.csv";
        
        // CSVファイルの読み込み処理
        $csvReader = new CsvReader($csvFilePath);
        
        // CSVファイルのデータを配列に変換
        $csvArrayData = $csvReader->convertCsvToArray();

        // ----------------------------------------
        //  大業種テーブルにデータを追加
        // ----------------------------------------
        // CSVデータ数分（CSVファイルの行数分）繰り返す
        foreach($csvArrayData as $csvArrayLineData){
                        
            DB::table('large_industries')->insert([
                'employment_site_id'    => $csvArrayLineData[0],
                'large_industries_id'   => $csvArrayLineData[1],
                'large_industries_name' => $csvArrayLineData[2],
                'created_at'            => date("Y-m-d H:i:s"),
                'updated_at'            => date("Y-m-d H:i:s")
            ]);
                
        }

    }
}
