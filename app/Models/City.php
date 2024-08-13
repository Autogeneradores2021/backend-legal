<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;


    /**
     * La tabla SUCURSAL tiene información relacionada con las cuentas de los bancos.
     * @var string
     */
    protected $table = 'view_common_city';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at','region','code_department'];
}
