<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTurns extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'doctor_id',
        'day',
        'time',
    ];
}
