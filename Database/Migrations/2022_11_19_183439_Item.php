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
        Schema::create('plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('plan_id');
            $table->foreignId('stage_id');
            $table->foreignId('item_template_id')->nullable();
            $table->foreignId('parent_item_id')->nullable();

            $table->string('title');
            $table->integer('points')->nullable();
            $table->boolean('is_done')->default(0);
            $table->date('commit_date')->nullable();
            $table->text('rrule')->nullable();
            // integration fields
            $table->text('resource_id')->nullable();
            $table->string('resource_type')->nullable();
            $table->string('resource_origin')->nullable();

            // fields
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->integer('inbox_order')->default(0);
            $table->boolean('is_pinned')->default(0);
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
