<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'boat_id',
        'stripe_session_id',
        'amount',
        'currency',
        'status'
    ];
}
