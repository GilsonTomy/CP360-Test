<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_master_id');
            $table->string('field_name',180);
            $table->tinyInteger('field_type')->default(1)->comment('1-Text, 2-Textarea, 3-Dropdown, 4-Number');
            $table->longText('field_values')->nullable()->comment('Used to store the field values as JSON');
            $table->foreign('form_master_id')->references('id')->on('form_masters')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('form_details');
    }
}
