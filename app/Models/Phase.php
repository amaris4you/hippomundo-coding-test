<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'task_count'
    ];

    function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
