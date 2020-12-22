<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of_tickets',
        'total_cost',
        'claimed',
        'claimed_date',
        'team_name',
        'email',
    ];
}
