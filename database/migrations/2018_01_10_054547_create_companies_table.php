<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {

            //------------------------------------------
            // 会社情報を管理するテーブル
            //------------------------------------------

            // カラム設定
            $table->char('company_id',20);                     // 会社ID          ※就職サイトID+会社IDの形式で登録させる
            $table->char('employment_site_id',20);             // 就職サイトID
            $table->string('company_name', 300)->nullable();   // 会社名
            $table->string('phone_number', 13)->nullable();    // 電話番号        ※ハイフンありの最大文字数が13桁である 電話番号は10桁か11桁
            $table->string('mail_address', 300)->nullable();   // メールアドレス  ※メールアドレスの最大文字数が254文字であるため
            $table->string('home_page_url', 2100)->nullable(); // ホームページURL ※IEで使用できる最大文字数が2083文字のため
            $table->string('ceo', 100)->nullable();            // 代表者名
            $table->string('capital_stock', 100)->nullable();  // 資本金
            $table->string('sales', 100)->nullable();          // 売上
            $table->timestamps();                              // 登録日時、更新日時

            // 主キーの設定
            $table->primary('company_id');

            // インデックスの設定
            $table->index('company_id');

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
        Schema::dropIfExists('companies');
    }
}
