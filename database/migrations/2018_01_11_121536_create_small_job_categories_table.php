<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //------------------------------------------
        // 大職種の情報を管理するテーブル
        //------------------------------------------

        // Create文のSQL文字列を作成する
        // ※通常のやり方だとプライマリーキーが長すぎますエラーがでてしまうため、Create文を直接実行する
        $runSqlString = "CREATE TABLE `small_job_categories`                                                                                                                                   " .
                        "(                                                                                                                                                                     " .
                        "    `employment_site_id`      CHAR(3)     NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                             " . // 就職サイトID
                        "    `large_job_category_id`   CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                             " . // 大職種ID
                        "    `small_job_category_id`   CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                             " . // 小職種ID
                        "    `small_job_category_name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',                                                                             " . // 小職種名
                        "    `created_at`              TIMESTAMP   NULL DEFAULT NULL,                                                                                                          " . // 登録日時
                        "    `updated_at`              TIMESTAMP   NULL DEFAULT NULL,                                                                                                          " . // 更新日時
                        "    PRIMARY KEY (`employment_site_id`, `large_job_category_id`, `small_job_category_id`),                                                                             " . // 主キー設定
                        "    INDEX small_job_categories_large_job_category_id_index(`large_job_category_id`),                                                                                  " . // インデックス設定(大職種ID)
                        "    INDEX small_job_categories_small_job_category_id_index(`small_job_category_id`),                                                                                  " . // インデックス設定(大職種ID)
                        "    CONSTRAINT `small_job_categories_employment_site_id_foreign`    FOREIGN KEY (`employment_site_id`)    REFERENCES `employment_sites`     (`employment_site_id`),   " . // 外部キー設定(就職サイトID)
                        "    CONSTRAINT `small_job_categories_large_job_category_id_foreign` FOREIGN KEY (`large_job_category_id`) REFERENCES `large_job_categories` (`large_job_category_id`) " . // 外部キー設定(大職種ID)
                        ")                                                                                                                                                                     " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                                          " .
                        "ENGINE=InnoDB                                                                                                                                                         " .
                        ";                                                                                                                                                                     ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        /*
        // 通常パターンの書き方
        Schema::create('small_job_categories', function (Blueprint $table) {

            //------------------------------------------
            // 小職種の情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);                    // 就職サイトID
            $table->char('large_job_category_id',10);                 // 大職種ID
            $table->char('small_job_category_id',10);                 // 小職種ID
            $table->string('small_job_category_name',50)->nullable(); // 小職種名
            $table->timestamps();                                     // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['employment_site_id', 'large_job_category_id','small_job_category_id']);

            // インデックスの設定
            $table->index('large_job_category_id');
            $table->index('small_job_category_id');

            // 外部キーの設定
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
        Schema::dropIfExists('small_job_categories');
    }
}