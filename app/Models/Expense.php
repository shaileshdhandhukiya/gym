<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'expense_date',
        'payment_mode_id',
        'description',
    ];

    // Define the relationship with PaymentMode
    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
