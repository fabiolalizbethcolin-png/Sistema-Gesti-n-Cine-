<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('funcions', function (Blueprint $table) {
            $table->integer('total_asientos')->default(100)->after('precio');
        });
    }

    public function down(): void
    {
        Schema::table('funcions', function (Blueprint $table) {
            $table->dropColumn('total_asientos');
        });
    }
};
