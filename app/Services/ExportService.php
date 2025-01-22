<?php

namespace App\Services;

use App\Services\Interfaces\ExportableInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExportService
{
    /**
     * Realiza la exportación de datos.
     */
    public function export(ExportableInterface $exportable)
    {

        Excel::store(
            new class ($exportable) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $exportable;

            public function __construct(ExportableInterface $exportable)
            {
                $this->exportable = $exportable;
            }

            public function collection()
            {
                return collect($this->exportable->getData());
            }

            public function headings(): array
            {
                return $this->exportable->getHeadings();
            }
            },
            $exportable->getFileName(),
            'public'
        );

        return config('app.url') . Storage::url($exportable->getFileName());
    }
}
