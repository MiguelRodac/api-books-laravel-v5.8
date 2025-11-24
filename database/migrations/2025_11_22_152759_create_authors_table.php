<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id_author');           // Primary key
            $table->string('name', 100)->unique();   // Author name
            $table->string('email', 100)->unique();  // Unique email
            $table->integer('books_published')->default(0); // Number of books published
            $table->text('bio', 500)->nullable();      // Biography
            $table->timestamps();                           // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
