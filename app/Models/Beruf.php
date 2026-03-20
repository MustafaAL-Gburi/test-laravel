<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beruf extends Model
{
    protected $table = 'berufe';

    public $timestamps = false;

    protected $fillable = [
        'beruf',
        'status',
        'fragebogen_id'
    ];
}