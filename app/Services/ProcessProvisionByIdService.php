<?php

namespace App\Services;

use App\Repositories\IPCRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\ProcessValueRepository;


class ProcessProvisionByIdService extends ProvisionService
{

    protected $processRepository;

    protected $processValueRepository;

    protected $iPCRepository;

    public function __construct(
        ProcessRepository $processRepository,
        ProcessValueRepository $processValueRepository,
        IPCRepository $iPCRepository
    ) {
        $this->processRepository = $processRepository;
        $this->processValueRepository = $processValueRepository;
        $this->iPCRepository = $iPCRepository;
    }

    /**
     * Obtener los IPC configurados en el sistema a partir del año y mes seleccionados.
     * @param mixed $startYear
     * @param mixed $startMonth
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getIpcs($startYear, $startMonth)
    {

        $month = str_pad($startMonth, 2, "0", STR_PAD_LEFT);
        $yearMonth = $startYear . $month;

        return $this->iPCRepository->whereQuery(['monthly_variation', 'years', 'month'], ['year_month' => ['>=', $yearMonth]])
            ->orderBy('YEAR_MONTH', 'ASC')
            ->get();
    }

    public function provisionById(int $processId, int $startYear, int $startMonth, bool $canBeSaved)
    {

        $process = $this->getProcessByid($processId);

        if (!$process) {
            throw new \Exception("El proceso no existe. Número de proceso: {$processId}");
        }

        $ipcs = $this->getIpcs($startYear, $startMonth);


        $processValues = [];

        foreach ($ipcs as &$ipc) {

            $process['provisions'] = $this->provisionByIPC($process['provisions'], $ipc['monthly_variation']);

            $processValues[] = [
                'process_id' => $process['id'],
                'state' => 0,
                'provisions' => $process['provisions'],
                'financial_report' => $process['provisions'],
                'demand' => $process['demand'],
                'ipc' => $ipc['monthly_variation'],
                'month' => $ipc['month'],
                'year' => $ipc['years']
            ];

        }

        $processValues[count($processValues) - 1]['state'] = 1;

        if ($canBeSaved) {
            $this->processValueRepository->insert($processValues);
        }

        return $processValues;

    }



}
