<?php

namespace App\Services;

use App\Repositories\ProcessRepository;

abstract class ProvisionService
{
    protected $processRepository;

    public function __construct(ProcessRepository $processRepository)
    {
        $this->processRepository = $processRepository;
    }

    public function provisionByIPC($provisionInicial, $variacionesIPC)
    {
        //Monto base del proyecto: El valor inicial o presupuestado del proyecto.
        $provisionInicial = str_replace('.', '', $provisionInicial);

        $montoBase = (float) $provisionInicial;

        //Variación mensual del IPC: Tasa de incremento o decremento mensual del IPC en porcentaje.
        $variacionesIPC = (float) $variacionesIPC;

        //La provisión para un mes se calcula como:

        $factor = 1 + ($variacionesIPC / 100);

        $provision = $montoBase * $factor;

        return round($provision, 0);
    }

    public function getProcess()
    {
        return $this->processRepository->selectCurrent(['id', 'provisions', 'demand', 'financial_report']);
    }

    public function getProcessByid(int $id)
    {
        return $this->processRepository->selectProcessById($id, ['id', 'provisions', 'demand', 'financial_report']);
    }

}
