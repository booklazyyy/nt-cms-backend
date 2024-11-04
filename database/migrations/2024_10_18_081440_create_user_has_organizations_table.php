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
        Schema::create('user_has_organizations', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('organization_id');
            $table->primary(['user_id', 'organization_id']);
            $table->foreign('user_id', 'FK_user_has_organizations_users')
                ->references('id')->on('users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreign('organization_id', 'FK_user_has_organizations_organizations')
                ->references('id')->on('organizations')
                ->noActionOnUpdate()
                ->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_organizations');
    }
};
