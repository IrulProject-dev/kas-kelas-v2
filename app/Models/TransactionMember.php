<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionMember extends Model
{
    protected $fillable = ['member_id', 'week_id', 'amount'];

    public function member() {
        return $this->belongsTo(Member::class);
    }
    public function week() {
        return $this->belongsTo(Week::class);
    }
}

