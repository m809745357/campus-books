<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('author');
            $table->string('published_at');
            $table->string('press');
            $table->string('type');
            $table->unsignedInteger('category_id');
            $table->string('keywords');
            $table->unsignedInteger('money');
            $table->string('logistics');
            $table->unsignedInteger('freight');
            $table->string('cover');
            $table->text('images');
            $table->text('body');
            $table->string('annex')->nullable();
            $table->integer('favorites_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);
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
        Schema::dropIfExists('books');
    }
}
