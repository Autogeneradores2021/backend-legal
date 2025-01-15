<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ExportableInterface
{

    public function setData(Collection $data);

    /**
     * Devuelve los datos a exportar.
     */
    public function getData();

    /**
     * Devuelve el nombre del archivo.
     */
    public function getFileName(): string;

    /**
     * Devuelve los encabezados del archivo.
     */
    public function getHeadings(): array;
}
