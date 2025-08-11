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
        Schema::table('entries', function (Blueprint $table) {
            $table->jsonb('data')->nullable()->after('url');
            $table->foreignId('entity_id')->nullable();
            $table->foreignId('entity_type_id')->nullable();

            $table->index(['entity_id', 'created_at']);
            $table->index(['entity_type_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropForeign(['entity_id']);
            $table->dropForeign(['entity_type_id']);
            $table->dropColumn(['data', 'entity_id', 'entity_type_id']);
        });
    }
};
