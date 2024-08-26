<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifica a coluna 'real_estate_id' para permitir valores NULL
        DB::statement('ALTER TABLE brokers ALTER COLUMN real_estate_id DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Modifica a coluna 'real_estate_id' para não permitir valores NULL
        DB::statement('ALTER TABLE brokers ALTER COLUMN real_estate_id SET NOT NULL');
    }
};
