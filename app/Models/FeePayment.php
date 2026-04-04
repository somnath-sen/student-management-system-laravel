<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;
    protected $fillable = ['fee_id', 'user_id', 'amount_paid', 'payment_method', 'transaction_id', 'receipt_path', 'status'];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}