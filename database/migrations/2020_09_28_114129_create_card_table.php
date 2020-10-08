<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('folder_id', false, true)
                    ->comment('フォルダID');
            $table->integer('title_cd')
                    ->nullable()
                    ->comment('タイトルID');
            $table->integer('card_no')
                    ->nullable()
                    ->comment('カードNo');
            $table->integer('symbol_cd')
                    ->nullable()
                    ->comment('シンボルID');
            $table->string('name', 64)
                    ->comment('カード名');
            $table->integer('amount')
                    ->default(0)
                    ->comment('数量');
            $table->boolean('get_flg')
                    ->default(false);
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
        Schema::dropIfExists('cards');
    }
}
