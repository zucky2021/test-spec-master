<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index()->comment('users.id');
            $table->unsignedBigInteger('spec_doc_sheet_id')->index()->comment('specification_document_sheets.id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('spec_doc_sheet_id')->references('id')->on('specification_document_sheets')->onDelete('cascade');

            $table->unique(['user_id', 'spec_doc_sheet_id'], 'unique_user_sheet');

            $table->comment('テスター管理テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testers');
    }
};
