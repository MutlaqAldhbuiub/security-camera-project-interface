<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->string('image_name');
            $table->bigInteger('application_id')->unsigned();
            $table->unsignedBigInteger('camera_id')->unsignedBigInteger();

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade');
            $table->foreign('camera_id')
                ->references('id')
                ->on('cameras')
                ->onDelete('cascade');
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
        Schema::dropIfExists('images');
    }
}
