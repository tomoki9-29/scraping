<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesLargeJobCategoriesTable extends Migration
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
        $runSqlString = "CREATE TABLE `companies_large_job_categories`                                                                                                                                    " .
                        "(                                                                                                                                                                                " .
                        "    `company_id`            CHAR(20)  NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                                    " . // 会社ID
                        "    `large_job_category_id` CHAR(10)  NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                                    " . // 大職種ID
                        "    `employment_site_id`    CHAR(3)   NOT NULL COLLATE  'utf8mb4_unicode_ci',                                                                                                    " . // 就職サイトID
                        "    `created_at`            TIMESTAMP NULL DEFAULT NULL,                                                                                                                         " . // 登録日時
                        "    `updated_at`            TIMESTAMP NULL DEFAULT NULL,                                                                                                                         " . // 更新日時
                        "    PRIMARY KEY (`company_id`, `large_job_category_id`),                                                                                                                         " . // 主キー設定
                        "    CONSTRAINT `companies_large_job_categories_company_id_foreign`            FOREIGN KEY (`company_id`)            REFERENCES `companies`            (`company_id`),            " . // 外部キー設定(会社ID)
                        "    CONSTRAINT `companies_large_job_categories_large_job_category_id_foreign` FOREIGN KEY (`large_job_category_id`) REFERENCES `large_job_categories` (`large_job_category_id`), " . // 外部キー設定(大職種ID)
                        "    CONSTRAINT `companies_large_job_categories_employment_site_id_foreign`    FOREIGN KEY (`employment_site_id`)    REFERENCES `employment_sites`     (`employment_site_id`)     " . // 外部キー設定(就職サイトID)
                        ")                                                                                                                                                                                " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                                                     " .
                        "ENGINE=InnoDB                                                                                                                                                                    " .
                        ";                                                                                                                                                                                ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        /*
        // 通常パターンの書き方
        Schema::create('companies_large_job_categories', function (Blueprint $table) {

            //------------------------------------------
            // 会社の大職種の情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('company_id',20);            // 会社ID
            $table->char('large_job_category_id',10); // 大職種ID
            $table->timestamps();                     // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['company_id', 'large_job_category_id']);

            // 外部キーの設定
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('large_job_category_id')->references('large_job_category_id')->on('large_job_categories');
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
        Schema::dropIfExists('companies_large_job_categories');
    }
}
