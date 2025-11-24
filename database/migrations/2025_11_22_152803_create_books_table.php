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
            $table->bigIncrements('id_book');           // Primary key
            $table->string('title');                    // Book title
            $table->text('description')->nullable();    // Book description
            $table->unsignedBigInteger('id_author');    // Author ID
            $table->date('published_at')->nullable();   // Publication date
            $table->boolean('available')->default(true); // Availability status
            $table->timestamps();                       // created_at and updated_at

            // Foreign key constraint
            $table->foreign('id_author')->references('id_author')->on('authors');
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
