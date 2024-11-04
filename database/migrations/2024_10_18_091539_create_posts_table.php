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
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('organization_id')->nullable();
            $table->enum('type', ['post', 'page', 'attatchment'])->default('post');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('slug', 200)->nullable();
            $table->text('title');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();
            $table->char('language', 2)->default('th');
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->string('password', 20)->nullable();
            $table->string('guid')->unique();
            $table->integer('menu_order')->default(0);
            $table->integer('ordered')->default(0);
            $table->string('mime_type', 100)->nullable();
            $table->dateTime('published_at')->nullable();
            $table->unsignedInteger('published_by')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->unsignedInteger('created_by')->nullable();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes('deleted_at');
            $table->unsignedInteger('deleted_by')->nullable();
            $table->foreign('user_id', 'FK_posts_users')
                ->references('id')->on('users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreign('organization_id', 'FK_posts_organizations')
                ->references('id')->on('organizations')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreign('parent_id', 'FK_posts_posts')
                ->references('id')->on('posts')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->foreign('created_by', 'FK_posts_created_by')
                ->references('id')->on('users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreign('updated_by', 'FK_posts_updated_by')
                ->references('id')->on('users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
