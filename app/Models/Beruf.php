<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beruf extends Model
{
    protected $table = 'berufe';

    public $timestamps = false;

    protected $fillable = [
   'beruf',
    'maennlich',
    'weiblich',
    'keywords',
    'ba_id',
    'status',
    'ba_zustand',
    'fragebogen_id'
];
}