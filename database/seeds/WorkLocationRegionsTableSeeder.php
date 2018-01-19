<?php

use Illuminate\Database\Seeder;

class WorkLocationRegionsTableSeeder extends Seeder
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
        $csvFilePath = base_path() . "/database/seedscsv/WorkLocationRegionsTableSeederCsv.csv";
        
        // CSVファイルの読み込み処理
        $csvReader = new CsvReader($csvFilePath);
        
        // CSVファイルのデータを配列に変換
        $csvArrayData = $csvReader->convertCsvToArray();

        // ----------------------------------------
        //  勤務地の地方テーブルにデータを追加
        // ----------------------------------------
        // CSVデータ数分（CSVファイルの行数分）繰り返す
        foreach($csvArrayData as $csvArrayLineData){
                        
            DB::table('work_location_regions')->insert([
                'employment_site_id'    => $csvArrayLineData[0],
                'region_id'             => $csvArrayLineData[1],
                'region_name'           => $csvArrayLineData[2],
                'created_at'            => date("Y-m-d H:i:s"),
                'updated_at'            => date("Y-m-d H:i:s")
            ]);
                
        }

    }
}
