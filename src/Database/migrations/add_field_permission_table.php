<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('pg_id')->default(0)->comment('权限组ID');
            $table->string('display_name', 50)->nullable()->comment('显示名称');
            $table->smallInteger('sort')->nullable();
            $table->string('description')->nullable();
            $table->string('created_name', 50)->nullable();
            $table->string('updated_name', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('p_id');
            $table->dropColumn('display_name');
            $table->dropColumn('icon');
            $table->dropColumn('sort');
            $table->dropColumn('description');
            $table->dropColumn('created_name');
            $table->dropColumn('updated_name');
        });
    }
}
