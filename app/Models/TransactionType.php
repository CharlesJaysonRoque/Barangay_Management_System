<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = [
        'description'
    ];

    public function transactions()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_type_id');
    }
}
