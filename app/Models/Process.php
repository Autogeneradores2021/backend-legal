<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'city',
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
        'failure_possibility'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
