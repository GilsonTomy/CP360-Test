<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('form_code')->nullable()->comment('Unique public access code for each form');
            $table->unsignedBigInteger('user_id');
            $table->integer('display_order')->default(1)->comment('Used for ordering of form');
            $table->tinyInteger('status')->default(1)->comment('1-Active, 0-Inactive');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('form_masters');
    }
}
