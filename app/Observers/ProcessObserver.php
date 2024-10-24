<?php

namespace App\Observers;

use App\Models\Ipc;
use App\Models\Process;
use App\Models\ProcessValue;
use App\Repositories\IPCRepository;
use App\Repositories\ProcessValueRepository;
use App\Services\CalculateIPCprovision;
use Illuminate\Support\Facades\Log;

class ProcessObserver
{

    protected $processValueRepository;

    public function __construct(ProcessValueRepository $processValueRepository)
    {
        Log::info("HOLAAAAA");
        $this->processValueRepository = $processValueRepository;
    }

    /**
     * Handle the Process "created" event.
     */
    public function created(Process $process): void
    {
        try {

            $fieldsNew = [
                'process_id' => $process->id,
                'state' => -1,
                'provisions' => floatval($process->provisions),
                'demand' => 0,
                'financial_report' => 0,
                'year' => $process->year,
                'month' => $process->month,
            ];

            $this->processValueRepository->create($fieldsNew);


            $iPCRepository = new IPCRepository(new Ipc());
            $processValueRepository = new ProcessValueRepository(new ProcessValue());
            $ipc = new CalculateIPCprovision($iPCRepository, $processValueRepository);
            $ipc->calculateProccess([$fieldsNew], $process->year, $process->month);


        } catch (\Throwable $th) {
            Log::info("ProcessObserver : " . $th->getMessage() . ' - ' . $th->getLine());
        } finally {

        }
    }

    /**
     * Handle the Process "updated" event.
     */
    public function updated(Process $process): void
    {
        try {

            $fieldsOld = [
                'demand' => $process->getOriginal('demand'),
                'provisions' => $process->getOriginal('provisions'),
                'financial_report' => $process->getOriginal('financial_report'),
            ];

            $fieldsNew = [
                'demand' => $process->demand,
                'provisions' => $process->provisions,
                'financial_report' => $process->financial_report,
            ];

            // $this->processValueRepository->create($process->id, $fieldsOld, $fieldsNew);
        } catch (\Throwable $th) {
            Log::info("ProcessObserver : " . $th->getMessage() - $th->getLine());
        }
    }

    /**
     * Handle the Process "deleted" event.
     */
    public function deleted(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "restored" event.
     */
    public function restored(Process $process): void
    {
        Log::info("ProcessObserver restored: ");
    }

    /**
     * Handle the Process "force deleted" event.
     */
    public function forceDeleted(Process $process): void
    {
        Log::info("ProcessObserver forceDeleted: ");
    }
}
