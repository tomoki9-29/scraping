<?php

use Illuminate\Database\Seeder;

class WorkLocationsTableSeeder extends Seeder
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
        $csvFilePath = base_path() . "/database/seedscsv/WorkLocationsTableSeederCsv.csv";
        
        // CSVファイルの読み込み処理
        $csvReader = new CsvReader($csvFilePath);
        
        // CSVファイルのデータを配列に変換
        $csvArrayData = $csvReader->convertCsvToArray();

        // ----------------------------------------
        //  勤務地の都道府県テーブルにデータを追加
        // ----------------------------------------
        // CSVデータ数分（CSVファイルの行数分）繰り返す
        foreach($csvArrayData as $csvArrayLineData){
                        
            DB::table('work_locations')->insert([
                'employment_site_id'    => $csvArrayLineData[0],
                'region_id'             => $csvArrayLineData[1],
                'prefecture_id'         => $csvArrayLineData[2],
                'prefecture_name'       => $csvArrayLineData[3],
                'created_at'            => date("Y-m-d H:i:s"),
                'updated_at'            => date("Y-m-d H:i:s")
            ]);
                
        }

    }
}
