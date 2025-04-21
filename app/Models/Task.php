<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = [
        'name',
        'status',
        'priority',
        'date',
        'created_by'
    ];
}
