<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesSmallIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create文のSQL文字列を作成する
        // ※通常のやり方だとプライマリーキーが長すぎますエラーがでてしまうため、Create文を直接実行する
        $runSqlString = "CREATE TABLE `companies_small_industries`                                                                                                                          " .
                        "(                                                                                                                                                                  " .
                        "    `company_id`          CHAR(20)  NOT NULL COLLATE   'utf8mb4_unicode_ci',                                                                                       " . // 会社ID
                        "    `large_industries_id` CHAR(10)  NOT NULL COLLATE   'utf8mb4_unicode_ci',                                                                                       " . // 大業種ID
                        "    `small_industries_id` CHAR(10)  NOT NULL COLLATE   'utf8mb4_unicode_ci',                                                                                       " . // 小業種ID
                        "    `employment_site_id`  CHAR(3)   NOT NULL COLLATE   'utf8mb4_unicode_ci',                                                                                       " . // 就職サイトID
                        "    `created_at`          TIMESTAMP NULL DEFAULT NULL,                                                                                                             " . // 登録日時
                        "    `updated_at`          TIMESTAMP NULL DEFAULT NULL,                                                                                                             " . // 更新日時
                        "    PRIMARY KEY (`company_id`, `large_industries_id`, `small_industries_id`),                                                                                      " . // 主キー設定
                        "    CONSTRAINT `companies_small_industries_company_id_foreign`          FOREIGN KEY (`company_id`)          REFERENCES `companies`        (`company_id`),          " . // 外部キー設定(会社ID)
                        "    CONSTRAINT `companies_small_industries_large_industries_id_foreign` FOREIGN KEY (`large_industries_id`) REFERENCES `small_industries` (`large_industries_id`), " . // 外部キー設定(大業種ID)
                        "    CONSTRAINT `companies_small_industries_small_industries_id_foreign` FOREIGN KEY (`small_industries_id`) REFERENCES `small_industries` (`small_industries_id`), " . // 外部キー設定(小業種ID)
                        "    CONSTRAINT `companies_small_industries_employment_site_id_foreign`  FOREIGN KEY (`employment_site_id`)  REFERENCES `employment_sites` (`employment_site_id`)   " . // 外部キー設定(就職サイトID)
                        ")                                                                                                                                                                  " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                                       " .
                        "ENGINE=InnoDB                                                                                                                                                      " .
                        ";                                                                                                                                                                  ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        //------------------------------------------
        // 会社の小業種の情報を管理するテーブル
        //------------------------------------------

        /*
        // 通常パターンの書き方
        Schema::create('companies_small_industries', function (Blueprint $table) {

            //------------------------------------------
            // 会社の小業種の情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('company_id',20);          // 会社ID
            $table->char('large_industries_id',10); // 大業種ID
            $table->char('small_industries_id',10); // 小業種ID
            $table->timestamps();                   // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['company_id', 'large_industries_id', 'small_industries_id']);

            // 外部キーの設定
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('large_industries_id')->references('large_industries_id')->on('large_industries');
            $table->foreign('small_industries_id')->references('small_industries_id')->on('small_industries');
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
        Schema::dropIfExists('companies_small_industries');
    }
}
