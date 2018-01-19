<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLargeIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('large_industries', function (Blueprint $table) {

            //------------------------------------------
            // 大業種を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);                  // 就職サイトID
            $table->char('large_industries_id',10);                 // 大業種ID
            $table->string('large_industries_name',50)->nullable(); // 大業種名
            $table->timestamps();                                   // 登録日時、更新日時

            // 主キーの設定
            $table->primary(['employment_site_id', 'large_industries_id']);

            // インデックスの設定
            $table->index('large_industries_id');

            // 外部キーの設定
            $table->foreign('employment_site_id')->references('employment_site_id')->on('employment_sites');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('large_industries');
    }
}
