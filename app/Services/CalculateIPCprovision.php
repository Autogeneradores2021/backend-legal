<?php

namespace App\Services;

use App\Repositories\IPCRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\ProcessValueRepository;

class CalculateIPCprovision
{
    protected $iPCRepository;
    protected $processValueRepository;


    public function __construct(IPCRepository $iPCRepository, ProcessValueRepository $processValueRepository)
    {
        $this->iPCRepository = $iPCRepository;
        $this->processValueRepository = $processValueRepository;
    }

    public function calculateAllByYear($year)
    {

        $process = $this->getProccess();
        foreach ($process as $proce) {

            for ($month = 1; $month <= 12; $month++) {

                $ipc = $this->iPCNowAndLast($year, $month);

                if ($ipc['ipcNow'] == 0) {
                    break;
                }

                $provisions = $this->calculateIPC($proce['provisions'], $ipc['ipcNow'], $ipc['ipcLast']);

                if ($ipc['ipcLast'] == 0) {
                    $provisions = $proce['provisions'];
                }

                $this->saveProvisions($proce['process_id'], $year, $month, $ipc['ipcNow'], $provisions);

            }

        }

    }

    private function saveProvisions($processId, $year, $month, $ipc, $provisions)
    {

        $monthNameNow = array_search($month, config('app.months'));

        $fieldsNew = [
            'process_id' => $processId,
            'state' => 0,
            'provisions' => floatval($provisions),
            'demand' => 0,
            'financial_report' => 0,
            'month' => $monthNameNow,
            'year' => $year,
            'ipc' => $ipc
        ];

        $this->processValueRepository->create($fieldsNew);
    }

    /**
     * Summary of calculateIPC
     * Calculate el IPC
     * @param mixed $provisions
     * @param mixed $ipcNow
     * @param mixed $ipcLast
     * @return float|null
     */
    private function calculateIPC($provisions, $ipcNow, $ipcLast)
    {
        $provision = null;

        if ($ipcNow != 0) {
            $provision = $provisions * ($ipcLast / $ipcNow);
        }

        return $provision;
    }

    /**
     * Summary of  iPCNowAndLast
     * @param mixed $year
     * @param mixed $monthNumber
     * @return array
     */
    private function iPCNowAndLast($year, $monthNumber)
    {
        $months = config('app.months');
        $monthNameNow = array_search($monthNumber, $months);

        $monthNumberLast = $monthNumber - 1;

        $monthNameLast = array_search($monthNumberLast == 0 ? 12 : $monthNumberLast, $months);

        $ipcNow = $this->getIPC($year, $monthNameNow);

        $ipcLast = $this->getIPC($monthNumberLast == 0 ? $year - 1 : $year, $monthNameLast);

        return ['ipcNow' => $ipcNow, 'ipcLast' => $ipcLast];

    }

    private function getProccess()
    {
        return $this->processValueRepository->whereQuery(['process_id', 'provisions'], ['state' => -1])->get()->toArray();
    }

    private function getIPC($year, $month)
    {
        $result = $this->iPCRepository->whereQuery(['ipc'], ['years' => $year, 'month' => $month])->first();
        if ($result) {
            return $result->ipc;
        }
        return 0;
    }

}
