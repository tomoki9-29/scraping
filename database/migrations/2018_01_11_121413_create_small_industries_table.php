<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //------------------------------------------
        // 小業種の情報を管理するテーブル
        //------------------------------------------

        // Create文のSQL文字列を作成する
        // ※通常のやり方だとプライマリーキーが長すぎますエラーがでてしまうため、Create文を直接実行する
        $runSqlString = "CREATE TABLE `small_industries`                                                                                                                         " .
                        "(                                                                                                                                                       " .
                        "    `employment_site_id`    CHAR(3)     NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                 " . // 就職サイトID
                        "    `large_industries_id`   CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                 " . // 大業種ID
                        "    `small_industries_id`   CHAR(10)    NOT NULL COLLATE          'utf8mb4_unicode_ci',                                                                 " . // 小業種ID
                        "    `small_industries_name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',                                                                 " . // 小業種名
                        "    `created_at`            TIMESTAMP   NULL DEFAULT NULL,                                                                                              " . // 登録日時
                        "    `updated_at`            TIMESTAMP   NULL DEFAULT NULL,                                                                                              " . // 更新日時
                        "    PRIMARY KEY (`employment_site_id`, `large_industries_id`, `small_industries_id`),                                                                   " . // 主キー設定
                        "    INDEX small_industries_large_industries_id_index(`large_industries_id`),                                                                            " . // インデックス設定(大業種ID)
                        "    INDEX small_industries_small_industries_id_index(`small_industries_id`),                                                                            " . // インデックス設定(小業種ID)
                        "    CONSTRAINT `small_industries_employment_site_id_foreign`  FOREIGN KEY (`employment_site_id`)  REFERENCES `employment_sites` (`employment_site_id`), " . // 外部キー設定(就職サイトID)
                        "    CONSTRAINT `small_industries_large_industries_id_foreign` FOREIGN KEY (`large_industries_id`) REFERENCES `large_industries` (`large_industries_id`) " . // 外部キー設定(大業種ID)
                        ")                                                                                                                                                       " .
                        "COLLATE='utf8mb4_unicode_ci'                                                                                                                            " .
                        "ENGINE=InnoDB                                                                                                                                           " .
                        ";                                                                                                                                                       ";

        // 作成したCreate文を実行する
        DB::statement($runSqlString);

        /*
        // 通常パターンの書き方
        Schema::create('small_industries', function (Blueprint $table) {

            //------------------------------------------
            // 小業種を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);                  // 就職サイトID
            $table->char('large_industries_id',10);                 // 大業種ID
            $table->char('small_industries_id',10);                 // 小業種ID
            $table->string('small_industries_name',50)->nullable(); // 小業種名
            $table->timestamps();                                   // 登録日時、更新日時

            // 主キーの設定 →ここでエラーが発生する！！
            $table->primary(['employment_site_id', 'large_industries_id', 'small_industries_id']);

            // 外部キーの設定
            $table->foreign('employment_site_id')->references('employment_site_id')->on('employment_sites');
            $table->foreign('large_industries_id')->references('large_industries_id')->on('large_industries');

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
        Schema::dropIfExists('small_industries');
    }
}
