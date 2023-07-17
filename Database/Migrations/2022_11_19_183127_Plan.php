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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('plan_type_id')->default(1);
            $table->foreignId('plan_template_id')->default(1);
            $table->foreignId('last_stage_id')->nullable();
            $table->foreignId('last_view_id')->default(1);

            $table->string('name');
            $table->text('description')->nullable();
            $table->text('cover')->nullable();
            $table->string('color')->nullable();

            $table->text('last_filter')->nullable();
            $table->boolean('is_pinned')->default(0);
            $table->boolean('show_in_home')->default(0);
            $table->json('show_in_sections')->default('[]');
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
