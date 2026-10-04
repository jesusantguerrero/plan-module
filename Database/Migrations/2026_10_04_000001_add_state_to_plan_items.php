<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * PlanItem syncs `is_done` with a 3-state `state` column (pending / buy / skip).
 * Loger added it in its own migration; apps that install the module fresh need it too.
 * Guarded so it is a no-op where the column already exists.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('plan_items', 'state')) {
            return;
        }

        Schema::table('plan_items', function (Blueprint $table) {
            $table->string('state', 16)->default('pending')->after('is_done');
        });

        DB::table('plan_items')->where('is_done', true)->update(['state' => 'buy']);
    }

    public function down(): void
    {
        // Left in place on purpose: the host app may own this column.
    }
};
