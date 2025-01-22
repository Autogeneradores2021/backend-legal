<?php

namespace App\Services;

use App\Repositories\ProcessValueRepository;

class ProcessProvisionService extends ProvisionService
{

    protected $processValueRepository;

    public function __construct(ProcessValueRepository $processValueRepository)
    {
        $this->processValueRepository = $processValueRepository;
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

            $process['demand'] = str_replace('.', '', $process['demand']);

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
            $this->processRepository->update($process['id'], [
                'provisions' => $process['provisions'],
                'financial_report' => $process['provisions']
            ]);
        }

    }

}
