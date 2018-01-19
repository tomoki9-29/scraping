<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //------------------------------------------
        // 勤務地の情報を管理するテーブル
        //------------------------------------------

        // Create文のSQL文字列を作成する
        // ※通常のやり方だとプライマリーキーが長すぎますエラーがでてしまうため、Create文を直接実行する
        $runSqlString = "CREATE TABLE `work_locations`                                                                                                                            " .
                        "(                                                                                                                                                        " .
                        "    `employment_site_id` CHAR(3)     NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                     " . // 就職サイトID
                        "    `region_id`          CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                     " . // 地方ID
                        "    `prefecture_id`      CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                     " . // 都道府県ID
                        "    `prefecture_name`    VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',                                                                     " . // 都道府県名
                        "    `created_at`         TIMESTAMP   NULL DEFAULT NULL,                                                                                                  " . // 登録日時
                        "    `updated_at`         TIMESTAMP   NULL DEFAULT NULL,                                                                                                  " . // 更新日時
                        "    PRIMARY KEY (`employment_site_id`, `region_id`, `prefecture_id`),                                                                                    " . // 主キー設定
                        "    INDEX work_locations_region_id_index(`region_id`),                                                                                                   " . // インデックス設定(地方ID)
                        "    INDEX work_locations_prefecture_id_index(`prefecture_id`),                                                                                           " . // インデックス設定(都道府県ID)
                        "    CONSTRAINT `work_locations_employment_site_id_foreign` FOREIGN KEY (`employment_site_id`) REFERENCES `employment_sites`      (`employment_site_id`), " . // 外部キー設定(就職サイトID)
                        "    CONSTRAINT `work_locations_region_id_foreign`          FOREIGN KEY (`region_id`)          REFERENCES `work_location_regions` (`region_id`)           " . // 外部キー設定(地方ID)
                        ")                                                                                                                                                        " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                             " .
                        "ENGINE=InnoDB                                                                                                                                            " .
                        ";                                                                                                                                                        ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        /*
        // 通常パターンの書き方
        Schema::create('work_locations', function (Blueprint $table) {

            //------------------------------------------
            // 勤務地の情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);            // 就職サイトID
            $table->char('region_id',10);                     // 地方ID
            $table->char('prefecture_id',10);                 // 都道府県ID
            $table->string('prefecture_name',50)->nullable(); // 都道府県名
            $table->timestamps();                             // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['employment_site_id', 'region_id', 'prefecture_id']);

            // 外部キーの設定
            $table->foreign('employment_site_id')->references('employment_site_id')->on('employment_sites');
            $table->foreign('region_id')->references('region_id')->on('work_location_regions');

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
        Schema::dropIfExists('work_locations');
    }
}
