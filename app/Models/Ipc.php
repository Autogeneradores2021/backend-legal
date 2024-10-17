<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ipc extends Model
{
    use HasFactory;

    protected $fillable = [
        'years',
        'month',
        'ipc_percentage',
        'ipc',
        'user_created',
        'user_updated'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Setter para ipc_percentage y para ipc (dividido entre 100)
    public function setIpcPercentageAttribute($value)
    {
        // Guardar el valor original en ipc_percentage
        $this->attributes['ipc_percentage'] = number_format((float) $value, 2, '.', '');

        // Asignar el valor dividido entre 100 a ipc
        $this->attributes['ipc'] = number_format((float) $value / 100, 4, '.', ''); // Opcionalmente, puedes ajustar el número de decimales
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
