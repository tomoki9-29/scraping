<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 書き方例： $this->call(UsersTableSeeder::class);

        // 初期値データをシーダクラスからセット
        $this->call([
            EmploymentSitesTableSeeder::class,     // 就職サイトテーブル
            WorkLocationRegionsTableSeeder::class, // 勤務地の地方テーブル
            WorkLocationsTableSeeder::class,       // 勤務地の都道府県テーブル
            LargeJobCategoriesTableSeeder::class,  // 大職種テーブル
            SmallJobCategoriesTableSeeder::class,  // 小職種テーブル
            LargeIndustriesTableSeeder::class,     // 大業種テーブル
            SmallIndustriesTableSeeder::class,     // 小業種テーブル
        ]);
    }
}
