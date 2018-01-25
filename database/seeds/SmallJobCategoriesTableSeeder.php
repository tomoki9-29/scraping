<?php

use Illuminate\Database\Seeder;

class SmallJobCategoriesTableSeeder extends Seeder
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
        $csvFilePath = base_path() . "/database/seedscsv/SmallJobCategoriesTableSeederCsv.csv";
        
        // CSVファイルの読み込み処理
        $csvReader = new CsvReader($csvFilePath);
        
        // CSVファイルのデータを配列に変換
        $csvArrayData = $csvReader->convertCsvToArray();

        // ----------------------------------------
        //  小職種テーブルにデータを追加
        // ----------------------------------------
        // CSVデータ数分（CSVファイルの行数分）繰り返す
        foreach($csvArrayData as $csvArrayLineData){
                        
            DB::table('small_job_categories')->insert([
                'employment_site_id'      => $csvArrayLineData[0],
                'large_job_category_id'   => $csvArrayLineData[1],
                'small_job_category_id'   => $csvArrayLineData[2],
                'small_job_category_name' => $csvArrayLineData[3],
                'created_at'              => date("Y-m-d H:i:s"),
                'updated_at'              => date("Y-m-d H:i:s")
            ]);
            
        }

    }
}
