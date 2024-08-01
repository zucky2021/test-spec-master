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
        Schema::create('specification_document_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spec_doc_sheet_id')->index()->comment('specification_document_sheets');
            $table->string('target_area')->comment('対象箇所');
            $table->string('check_details')->comment('確認内容');
            $table->string('remark')->nullable()->comment('備考');
            $table->unsignedTinyInteger('status_id')->default(0)->comment('0=Pending, 1=OK, 2=NG');
            $table->timestamps();

            $table->foreign('spec_doc_sheet_id')->references('id')->on('specification_document_sheets')->onDelete('cascade');

            $table->comment('テスト項目管理テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_document_items');
    }
};
