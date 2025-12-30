<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['nim', 'name', 'batch'];

    public function transaction_members()
    {
        return $this->hasMany(TransactionMember::class);
    }
}
