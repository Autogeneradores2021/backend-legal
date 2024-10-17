<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipcs', function (Blueprint $table) {
            $table->id();
            $table->string('years', 4);
            $table->string('month', 15);
            $table->double('ipc_percentage');
            $table->double('ipc');
            $table->string('user_created', 255);
            $table->string('user_updated', 255)->nullable();
            $table->timestamps();

            // Crear un índice único en las columnas years y month
            $table->unique(['years', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipc');
    }
};
