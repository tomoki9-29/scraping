<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRikunavisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rikunavis', function (Blueprint $table) {
            $table->increments('company_id');
            $table->string('company_name', 2550)->nullable();
            $table->text('contact_address', 1500)->nullable();   // どれだけのものが格納されるかわからないのでTEXTで宣言
            $table->string('mail_address', 3000)->nullable();    // メールアドレスの最大文字数(256文字)
            $table->string('home_page_url', 2100)->nullable();  // IEのURLのMAX制限2083が格納できる数
            $table->string('ceo', 2000)->nullable();
            $table->string('capital_stock', 3000)->nullable();
            $table->string('sales', 1500)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rikunavis');
    }
}