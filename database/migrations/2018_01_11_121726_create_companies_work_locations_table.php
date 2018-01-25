<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesWorkLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //------------------------------------------
        // 会社の勤務地の情報を管理するテーブル
        //------------------------------------------

        // Create文のSQL文字列を作成する
        // ※通常のやり方だとプライマリーキーが長すぎますエラーがでてしまうため、Create文を直接実行する
        $runSqlString = "CREATE TABLE `companies_work_locations`                                                                                                                      " .
                        "(                                                                                                                                                            " .
                        "    `company_id`         CHAR(20)  NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                   " . // 会社ID
                        "    `region_id`          CHAR(10)  NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                   " . // 地方ID
                        "    `prefecture_id`      CHAR(10)  NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                   " . // 都道府県ID
                        "    `employment_site_id` CHAR(3)   NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                   " . // 就職サイトID
                        "    `created_at`         TIMESTAMP NULL DEFAULT NULL,                                                                                                        " . // 登録日時
                        "    `updated_at`         TIMESTAMP NULL DEFAULT NULL,                                                                                                        " . // 更新日時
                        "    PRIMARY KEY (`company_id`, `region_id`, `prefecture_id`),                                                                                                " . // 主キー設定
                        "    CONSTRAINT `companies_work_locations_company_id_foreign`         FOREIGN KEY (`company_id`)         REFERENCES `companies`        (`company_id`),        " . // 外部キー設定(会社ID)
                        "    CONSTRAINT `companies_work_locations_region_id_foreign`          FOREIGN KEY (`region_id`)          REFERENCES `work_locations`   (`region_id`),         " . // 外部キー設定(地方ID)
                        "    CONSTRAINT `companies_work_locations_prefecture_id_foreign`      FOREIGN KEY (`prefecture_id`)      REFERENCES `work_locations`   (`prefecture_id`),     " . // 外部キー設定(都道府県ID)
                        "    CONSTRAINT `companies_work_locations_employment_site_id_foreign` FOREIGN KEY (`employment_site_id`) REFERENCES `employment_sites` (`employment_site_id`) " . // 外部キー設定(就職サイトID)
                        ")                                                                                                                                                            " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                                 " .
                        "ENGINE=InnoDB                                                                                                                                                " .
                        ";                                                                                                                                                            ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        /*
        // 通常パターンの書き方
        Schema::create('companies_work_locations', function (Blueprint $table) {

            //------------------------------------------
            // 会社の勤務地の情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('company_id',20);              // 会社ID
            $table->char('work_location_region_id',10); // 勤務地地方ID
            $table->char('work_location_id',10);        // 勤務地ID
            $table->timestamps();                       // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['company_id', 'work_location_region_id', 'work_location_id']);

            // 外部キーの設定
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('region_id')->references('region_id')->on('work_locations');
            $table->foreign('prefecture_id')->references('prefecture_id')->on('work_locations');
            $table->foreign('employment_site_id')->references('employment_site_id')->on('employment_sites');

        });
        */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_work_locations');
    }
}
