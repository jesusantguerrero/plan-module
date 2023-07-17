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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('entity_id');
            $table->string('entity_type');

            // Basic
            $table->integer('index')->default(0);
            $table->string('name');
            $table->string('title');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_required')->default(0);
            $table->boolean('is_manual')->default(0);
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
