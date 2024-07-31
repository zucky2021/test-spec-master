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
        Schema::create('execution_environments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('実施環境名');
            $table->unsignedSmallInteger('order_num')->default(1)->unique()->comment('並び順');
            $table->boolean('is_display')->default(true)->comment('表示フラグ');
            $table->timestamps();

            $table->comment('実施環境管理テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_agents');
    }
};
