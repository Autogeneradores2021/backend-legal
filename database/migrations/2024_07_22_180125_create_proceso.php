<?php

use App\Models\Action;
use App\Models\City;
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
            $table->string('city_id', 6)->comment("Código DANE");

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

            $table->boolean('failure_possibility_niif');

            $table->decimal('demand', 20)->comment('valor de demanda');
            $table->decimal('provisions', 20)->comment('valor de provision');
            $table->decimal('financial_report', 20)->comment('valor reporte al area financiera');

            $table->string('year', 4);
            $table->string('month', 15);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->string('user_created', 255);
            $table->string('user_updated', 255)->nullable();

            $table->string('user', 255);
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
