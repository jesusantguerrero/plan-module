<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('field_id');
            $table->foreignId('entity_id');
            $table->string('resource');

            // Basic
            $table->string('entity_type');
            $table->string('field_name');
            $table->text('field_title');
            $table->text('value');
            $table->date('date_value')->nullable();
            $table->time('time_value')->nullable();
            $table->decimal('decimal_value', 11, 2)->nullable();
            $table->boolean('check_value')->nullable();
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
        //
    }
};
