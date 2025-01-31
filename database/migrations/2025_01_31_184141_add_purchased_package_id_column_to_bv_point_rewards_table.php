<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bv_point_rewards', function (Blueprint $table) {
            $table->foreignId('bv_point_earning_id')->nullable()->after('parent_id')->constrained()->noActionOnDelete();
            $table->foreignId('level_user_id')->nullable()->after('user_id')->constrained('users')->noActionOnDelete();
            $table->foreignId('purchased_package_id')->nullable()->after('level_user_id')->constrained('purchased_package')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bv_point_rewards', function (Blueprint $table) {
            //
        });
    }
};
