<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string("last_name");
            $table->string("phone_numebr")->unique()->nullable();
            $table->longText("address")->nullable();
            $table->enum("login_type",['google','email'])->nullable();
            $table->enum("gender",["male",'female'])->nullable();
            $table->enum("status",["active","in-active"])->default("active");
            $table->string("profile_image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["last_name","phone_numebr","address","login_type","gender","status","profile_image"]);
        });
    }
};
