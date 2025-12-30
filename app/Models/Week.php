<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = ['name', 'start_date', 'nominal'];

    public function transaction_members()
    {
        return $this->hasMany(TransactionMember::class);
    }
}
