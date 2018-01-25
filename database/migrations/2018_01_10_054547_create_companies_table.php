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
            $table->char('company_id',15);                     // 会社ID  MAX 10byte        ※就職サイトID+会社IDの形式で登録させる
            $table->char('employment_site_id',20);             // 就職サイトID MAX 3byte
            $table->string('company_name', 300)->nullable();   // 会社名 MAX885byte
            $table->string('phone_number', 20)->nullable();    // 電話番号 MAX 14byte        ※ハイフンありの最大文字数が13桁である 電話番号は10桁か11桁
            $table->string('mail_address', 1000)->nullable();   // メールアドレス MAX 43byte ※メールアドレスの最大文字数が254文字であるため
            $table->string('home_page_url', 1000)->nullable(); // ホームページURL MAX 971byte ※IEで使用できる最大文字数が2083文字のため
            $table->string('ceo', 2000)->nullable();            // 代表者名 MAX 4065byte
            $table->string('capital_stock', 1500)->nullable();  // 資本金 MAX472byte
            $table->string('sales', 2000)->nullable();          // 売上 MAX 1630byte
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
