<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Adds nullable created_at and updated_at to `events` and `announcement` tables
     * and backfills created_at from `created_at`/`date_posted` where available.
     * This migration is safe to run multiple times (checks for column existence).
     */
    public function up()
    {
        if (Schema::hasTable('events')) {
            if (!Schema::hasColumn('events', 'created_at')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dateTime('created_at')->nullable()->after('location');
                });
                // Backfill created_at with now() for existing rows if null
                DB::table('events')->whereNull('created_at')->update(['created_at' => DB::raw('CURRENT_TIMESTAMP')]);
            }

            if (!Schema::hasColumn('events', 'updated_at')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dateTime('updated_at')->nullable()->after('created_at');
                });
            }
        }

        if (Schema::hasTable('announcement')) {
            if (!Schema::hasColumn('announcement', 'created_at')) {
                Schema::table('announcement', function (Blueprint $table) {
                    $table->dateTime('created_at')->nullable()->after('date_posted');
                });
                // Backfill created_at from date_posted where possible
                if (Schema::hasColumn('announcement', 'date_posted')) {
                    DB::table('announcement')->whereNull('created_at')->update(['created_at' => DB::raw('date_posted')]);
                    // For rows where date_posted is null, set to now()
                    DB::table('announcement')->whereNull('created_at')->update(['created_at' => DB::raw('CURRENT_TIMESTAMP')]);
                } else {
                    DB::table('announcement')->whereNull('created_at')->update(['created_at' => DB::raw('CURRENT_TIMESTAMP')]);
                }
            }

            if (!Schema::hasColumn('announcement', 'updated_at')) {
                Schema::table('announcement', function (Blueprint $table) {
                    $table->dateTime('updated_at')->nullable()->after('created_at');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * Drops the added columns if they exist.
     */
    public function down()
    {
        if (Schema::hasTable('events')) {
            if (Schema::hasColumn('events', 'updated_at')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dropColumn('updated_at');
                });
            }
            if (Schema::hasColumn('events', 'created_at')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dropColumn('created_at');
                });
            }
        }

        if (Schema::hasTable('announcement')) {
            if (Schema::hasColumn('announcement', 'updated_at')) {
                Schema::table('announcement', function (Blueprint $table) {
                    $table->dropColumn('updated_at');
                });
            }
            if (Schema::hasColumn('announcement', 'created_at')) {
                Schema::table('announcement', function (Blueprint $table) {
                    $table->dropColumn('created_at');
                });
            }
        }
    }
};
