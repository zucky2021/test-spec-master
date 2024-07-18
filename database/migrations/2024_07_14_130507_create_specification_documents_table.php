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
        Schema::create('specification_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->index()->comment('プロジェクトID');
            $table->unsignedBigInteger('user_id')->nullable()->index()->comment('ユーザーID');
            $table->string('title')->comment('タイトル');
            $table->text('summary')->comment('概要');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->comment('仕様書管理テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_documents');
    }
};
