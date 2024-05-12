<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'startTime',
        'endTime',
        'manualEntry',
        'updatedManually',
        'user_id',
        'project_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'startTime' => 'datetime',
        'manualEntry' => 'boolean',
        'updatedManually' => 'boolean',
    ];
}
