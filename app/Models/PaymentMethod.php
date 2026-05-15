<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'method',
    ];

    public function payments()
    {
        return $this->hasMany(TransactionDetail::class, 'payment_method_id');
    }
}
