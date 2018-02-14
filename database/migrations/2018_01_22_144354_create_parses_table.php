<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Column types: https://laravel.com/docs/5.5/migrations#creating-columns
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_name', 255);
            $table->string('forum_link', 255);
            $table->string('parse_link', 255);
            $table->dateTime('parse_date');
            $table->decimal('parse_dps', 10, 2);
            $table->string('advanced_class', 255);
            $table->string('specialization', 255);
            $table->boolean('is_crazy');
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
        Schema::dropIfExists('parses');
    }
}
