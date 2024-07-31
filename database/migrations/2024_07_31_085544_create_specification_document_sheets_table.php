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
        Schema::create('specification_document_sheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spec_doc_id')->nullable()->comment('specification_documents.id');
            $table->unsignedBigInteger('exec_env_id')->nullable()->comment('execution_environments.id');
            $table->unsignedTinyInteger('status_id')->comment('0=Pending, 1=In progress, 2=Completed, 3=NG');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('spec_doc_id')->references('id')->on('specification_documents')->onDelete('set null');
            $table->foreign('exec_env_id')->references('id')->on('execution_environments')->onDelete('set null');

            $table->unique(['spec_doc_id', 'exec_env_id']);

            $table->comment('シート(実施環境毎の仕様書)管理テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_document_sheets_table');
    }
};
