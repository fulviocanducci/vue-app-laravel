<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->integer('id', true);

            $table->string('name', 250);
            $table->smallInteger('type');
            $table->boolean('status');
            $table->integer('form_id');

            $table->foreign('form_id')->references('id')->on('forms');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
