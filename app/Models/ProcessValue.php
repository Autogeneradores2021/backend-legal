<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessValue extends Model
{
    use HasFactory;


    protected $fillable = [
        'process_id',
        'state',
        'demand',
        'provisions',
        'financial_report',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
