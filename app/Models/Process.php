<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'city_id',
        'office_id',
        'demanding_id',
        'defendant_id',
        'attorney_id',
        'niu',
        'reference_internal',
        'reference_external',
        'facts',
        'class_procces_id',
        'action_id',
        'status_id',
        'failure_possibility_id',
        'failure_possibility_niif',
        'demand',
        'provisions',
        'financial_report',
        'user_created',
        'user_updated',
        'year',
        'month'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *Relaciones
     *
     */
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function demanding()
    {
        return $this->belongsTo(Person::class, 'demanding_id');
    }

    public function defendant()
    {
        return $this->belongsTo(Person::class, 'defendant_id');
    }

    public function attorney()
    {
        return $this->belongsTo(Person::class, 'attorney_id');
    }

    public function classProcces()
    {
        return $this->belongsTo(ClassProcces::class, 'class_procces_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function failurePossibility()
    {
        return $this->belongsTo(FailurePossibility::class, 'failure_possibility_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function processValues()
    {
        return $this->hasMany(ProcessValue::class, 'process_id', 'id');
    }

    /**
     * Obtener el primer ProcessValue con el estado 1.
     */
    public function firstActiveProcessValue()
    {
        return $this->processValues()->first();
    }

    /**
     * Casts
     */
    // Accesor para formatear el precio
    protected function casts(): array
    {
        return [
            /* 'demand' => MoneyCast::class,
             'provisions' => MoneyCast::class,
             'financial_report' => MoneyCast::class,*/
        ];
    }
}
