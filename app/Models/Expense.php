<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'amount',
        'category',
        'date',
        'note',
        'user_id',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

}
