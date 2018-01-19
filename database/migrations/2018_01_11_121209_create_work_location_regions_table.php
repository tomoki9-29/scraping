<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkLocationRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_location_regions', function (Blueprint $table) {

            //------------------------------------------
            // 勤務地の地方情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('employment_site_id', 3);        // 就職サイトID
            $table->char('region_id',10);                 // 地方ID
            $table->string('region_name',50)->nullable(); // 地方名
            $table->timestamps();                         // 登録日時、更新日時

            // 主キーの設定
            $table->primary(['employment_site_id', 'region_id']);

            // インデックスの設定
            $table->index('region_id');

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
        Schema::dropIfExists('work_location_regions');
    }
}
