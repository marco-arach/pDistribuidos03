<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'ci';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'cliente';
    protected $fillable = [
        'ci',
        'nombre',
        'telefono',
        'direccion',
        'email',
    ];
}
