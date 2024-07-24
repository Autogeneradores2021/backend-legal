<?php

use App\Models\Action;
use App\Models\ClassProcces;
use App\Models\Office;
use App\Models\Status;
use App\Models\FailurePossibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('city', 6)->comment("Código DANE");
            $table->foreignIdFor(Office::class)->constrained();

            $table->foreignId('demanding_id')->comment("demandante")->constrained('persons');
            $table->foreignId('defendant_id')->comment("demandado")->constrained('persons');
            $table->foreignId('attorney_id')->comment('apoderado')->constrained('persons');

            $table->string('niu', 255);
            $table->string('reference_internal', 255)->comment('radicacion_interna');
            $table->string('reference_external', 255)->comment('radicacion_externa');
            $table->string('facts', 500);

            $table->foreignIdFor(ClassProcces::class)->constrained();
            $table->foreignIdFor(Action::class)->constrained();
            $table->foreignIdFor(Status::class)->constrained();

            $table->foreignIdFor(FailurePossibility::class)->constrained();

            $table->boolean('failure_possibility');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
