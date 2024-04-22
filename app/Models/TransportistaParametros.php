<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportistaParametros extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'peso',
        'cantidad',
    ];
}
