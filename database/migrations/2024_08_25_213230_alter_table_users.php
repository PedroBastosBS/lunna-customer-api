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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('type')->nullable()->comment('1 - usuario_cliente; 2 - usuario_anunciante');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->integer('address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('instagram');
            $table->dropColumn('facebook');
            $table->dropColumn('address_id');
        });
    }
};
