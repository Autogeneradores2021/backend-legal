<?php

namespace App\Services;

use App\Repositories\IPCRepository;

class IPCMonthlyVariationService
{

    protected $iPCRepository;


    public function __construct(IPCRepository $iPCRepository)
    {
        $this->iPCRepository = $iPCRepository;
    }

    /**
     * Summary of orderByMonth
     * @param array $months
     * @return array
     */
    private function orderByMonth(array $months): array
    {
        $order = [
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        ];

        usort($months, function ($a, $b) use ($order) {
            $posA = array_search(strtolower($a['month']), $order);
            $posB = array_search(strtolower($b['month']), $order);
            return $posA <=> $posB;
        });

        return $months;
    }


    /**
     * Summary of calculer
     * @param array $ipcs
     * @return array
     */
    private function calculer(array $ipcs): array
    {

        for ($i = 1; $i < count($ipcs); $i++) {

            if (!isset($ipcs[$i - 1]['ipc_percentage'])) {
                continue;
            }

            $ipcNow = $ipcs[$i]['ipc_percentage'];
            $ipcBefore = $ipcs[$i - 1]['ipc_percentage'];

            // Calcular la variación porcentual
            $variation = (($ipcNow - $ipcBefore) / $ipcBefore) * 100;

            // Guardar el resultado
            $ipcs[$i]['monthly_variation'] = round($variation, 2);

        }

        return $ipcs;
    }

    /**
     * Summary of updateIpcs
     * @param array $ipcs
     * @return void
     */
    private function updateIpcs(array $ipcs)
    {
        foreach ($ipcs as $index => $ipc) {
            $this->iPCRepository->update($ipc['id'], [
                'monthly_variation' => $ipc['monthly_variation']
            ]);
        }
    }

    /**
     * Summary of calculerVariation
     * @param int $year
     * @return void
     */
    public function calculerVariation(int $year): array
    {

        $ipcs = $this->iPCRepository->whereQuery(['ID', 'IPC', 'IPC_PERCENTAGE', 'MONTH', 'MONTHLY_VARIATION'], ['YEARS' => $year])->get();
        $ipcsYear = $this->orderByMonth($ipcs->toArray());
        $variationIpcs = $this->calculer($ipcsYear);
        $this->updateIpcs($variationIpcs);

        return $variationIpcs;
    }



}
