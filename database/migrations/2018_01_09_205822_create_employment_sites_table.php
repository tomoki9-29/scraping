<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_sites', function (Blueprint $table) {

            //------------------------------------------
            // 就職サイト情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);
            $table->string('site_name', 100)->nullable();
            $table->timestamps();                         // 登録日時、更新日時

            // 主キーの設定
            $table->primary('employment_site_id');

            // インデックスの設定
            $table->index('employment_site_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_sites');
    }
}
