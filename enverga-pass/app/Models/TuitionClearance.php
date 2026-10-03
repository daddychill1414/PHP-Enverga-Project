<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'student_name',
        'department',
        'tuition_balance',
        'is_cleared',
        'cleared_semester',
    ];

    protected $casts = [
        'is_cleared' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
