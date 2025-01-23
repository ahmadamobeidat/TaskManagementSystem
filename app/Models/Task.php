<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status',
        'priority',
    ];


    protected $casts = [
        'due_date' => 'date',
    ];

    // ===================================================================================================================
    // ============================================= RelationShips Section ===============================================
    // ===================================================================================================================
    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ===================================================================================================================
    // ============================================== accessories Section ================================================
    // ===================================================================================================================
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'To Do';
        } elseif ($value == 2) {
            return 'In Progress';
        } elseif ($value == 3) {
            return 'Completed';
        }
    }

    public function getPriorityAttribute($value)
    {
        if ($value == 1) {
            return 'High';
        } elseif ($value == 2) {
            return 'Medium';
        } elseif ($value == 3) {
            return 'Low';
        }
    }
}
