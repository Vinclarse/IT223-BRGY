<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('resident') && !Schema::hasColumn('resident', 'status')) {
            Schema::table('resident', function (Blueprint $table) {
                $table->string('status')->default('Pending')->after('date_registered');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('resident') && Schema::hasColumn('resident', 'status')) {
            Schema::table('resident', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
