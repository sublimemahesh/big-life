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
        DB::statement("ALTER TABLE `bv_point_rewards` CHANGE `status` `status` ENUM('pending','claimed','hold','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
        Schema::table('bv_point_rewards', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('bv_point_rewards')->cascadeOnDelete();
            $table->double('paid')->default(0)->after('amount');
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
