<?php

namespace App\Exports;

use App\Services\Interfaces\ExportableInterface;
use Illuminate\Database\Eloquent\Collection;


class ProcessExport implements ExportableInterface
{
    private Collection $data;

    public function setData(Collection $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data->map(function ($item) {
            return [
                'Ciudad' => $item->city->department . ' - ' . $item->city->city,
                'Despacho' => $item->office->name,
                'Demandante' => $item->demanding->full_name,
                'NIT / CC Demandante' => $item->demanding->number_doc,
                'Demandado' => $item->defendant->full_name,
                'NIU - EKOGUI' => $item->niu,
                'Radicación Interna' => $item->reference_internal,
                'Radicación Externa' => $item->reference_external,
                'Cuantía demanda' => $item->demand,
                'Provisión contable' => $item->provisions,
                'Reporte financiera' => $item->financial_report,
                'Clase' => $item->classProcces->name,
                'Tipo de acción' => $item->action->name,
                'Instancia' => $item->status->name,
                'Pos.Fallo adverso' => $item->failurePossibility->name,
                'NIIF - Pos.Fallo adverso' => $item->failure_possibility_niif == "1" ? "Si" : "No",
                'Apoderado' => $item->attorney->full_name
            ];
        });
    }

    public function getFileName(): string
    {

        return 'procesos_' . now() . '.xlsx';
    }

    public function getHeadings(): array
    {
        return [
            'Ciudad',
            'Despacho',
            'Demandante',
            'NIT / CC Demandante',
            'Demandado',
            'NIU - EKOGUI',
            'Radicación Interna',
            'Radicación Externa',
            'Cuantía demanda',
            'Provisión contable',
            'Reporte financiera',
            'Clase',
            'Tipo de acción',
            'Instancia',
            'Pos.Fallo adverso',
            'NIIF - Pos.Fallo adverso',
            'Apoderado'
        ];
    }
}
