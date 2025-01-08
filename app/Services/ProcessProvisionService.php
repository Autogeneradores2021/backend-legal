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
        $this->processRepository->disableCustomCasts();
    }

    private function getProcess()
    {
        return $this->processRepository->selectCurrent(['id', 'provisions', 'demand', 'financial_report']);
    }


    private function provisionByIPC($provisionInicial, $variacionesIPC)
    {

        $provisionInicial = str_replace('.', '', $provisionInicial);

        $provision = (float) $provisionInicial;

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

        \Log::info("****HHHHHH***");
        \Log::info(count($processes));

        $this->processValueRepository->disabledBefore();

        $processValues = [];
        foreach ($processes as $index => $process) {

            $process['demand'] = str_replace('.', '', $process['demand']);
            $process['financial_report'] = $process['provisions'];

            $processValues[] = [
                'process_id' => $process['id'],
                'state' => 1,
                'provisions' => $process['provisions'],
                'financial_report' => $process['provisions'],
                'demand' => $process['demand'],
                'ipc' => $ipc,
                'month' => $month,
                'year' => $year
            ];
        }

        $this->processValueRepository->insert($processValues);



        foreach ($processes as $index => $process) {
            \Log::info("wwwwwwwwwwwww");
            \Log::info($process);

            $this->processRepository->update($process['id'], [
                'provisions' => $process['provisions'],
                'financial_report' => $process['financial_report']
            ]);
        }


    }

}
