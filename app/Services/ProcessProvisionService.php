<?php

namespace App\Services;

use App\Repositories\ProcessRepository;
use App\Repositories\ProcessValueRepository;


class ProcessProvisionService
{

    protected $processRepository;

    protected $processValueRepository;

    public function __construct(ProcessRepository $processRepository, ProcessValueRepository $processValueRepository)
    {
        $this->processRepository = $processRepository;
        $this->processValueRepository = $processValueRepository;
    }

    private function getProcess()
    {
        return $this->processRepository->selectCurrent(['id', 'provisions', 'demand']);
    }


    private function provisionByIPC($provisionInicial, $variacionesIPC)
    {
        \Log::info("*******");
        \Log::info($provisionInicial);
        \Log::info($variacionesIPC);

        $provision = $provisionInicial;

        $provision *= (1 + $variacionesIPC / 100);

        return round($provision, 2);
    }

    private function calculateProvisions($ipc)
    {

        $processes = $this->getProcess();
        if (empty($processes)) {
            throw new \Exception("No hay procesos vigentes");
        }

        $processes = $processes->toArray();

        foreach ($processes as &$process) {
            $process['provisions'] = $this->provisionByIPC($process['provisions'], $ipc);
        }

        return $processes;
    }

    public function provision($year, $month, $ipc)
    {

        $processes = $this->calculateProvisions($ipc);

        $this->processValueRepository->disabledBefore();

        $processValues = [];
        foreach ($processes as $index => $process) {
            $processValues[] = [
                'process_id' => $process['id'],
                'state' => 1,
                'provisions' => $process['provisions'],
                'financial_report' => $process['provisions'],
                'ipc' => $ipc,
                'month' => $month,
                'year' => $year
            ];
        }

        $this->processValueRepository->insert($processValues);


        foreach ($processes as $index => $process) {
            $this->processRepository->update($process['id'], [
                'provisions' => $process['provisions'],
                'financial_report' => $process['financial_report']
            ]);
        }


    }

}
