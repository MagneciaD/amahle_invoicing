<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'company_name',
        'company_logo',
        'company_details',
        'signature',
        'banking_details',
        'number',
        'email',
        'payment_frequency',
        'date',
        'amount',
        'last_payment_date',
        'next_payment_due',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
