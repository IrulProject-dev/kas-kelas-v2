<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'amount',
        'transaction_date',
        'description',
    ];

    // Casting agar tanggal otomatis jadi objek Carbon
    protected $casts = [
        'transaction_date' => 'date',
    ];
}
