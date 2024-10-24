<?php

use App\Models\Process;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('process_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Process::class)->constrained();
            $table->string('year', 4);
            $table->string('month', 15);
            $table->double('ipc');
            $table->boolean('state')->comment("1 Activo - 0 Inactivo");
            $table->decimal('demand', 20)->comment('valor de demanda');
            $table->decimal('provisions', 20)->comment('valor de provision');
            $table->decimal('financial_report', 20)->comment('valor reporte al area financiera');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('user', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_values');
    }
};
