<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()                // 既存データを保持するため null 許容
                ->after('id')
                ->constrained('users')      // users.id に紐づく外部キー制約
                ->onDelete('cascade');      // ユーザー削除時に関連商品も削除
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
