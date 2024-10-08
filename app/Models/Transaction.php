<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    // Define which fields can be mass-assigned
    protected $fillable = [
        'user_id',
        'amount',
        'transaction_status',
        'midtrans_transaction_id',
        'paid_at',
    ];

    // Cast the 'paid_at' field to a Carbon date object
    protected $dates = ['paid_at'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
