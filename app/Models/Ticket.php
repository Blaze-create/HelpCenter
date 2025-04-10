<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Specify the table name if it does not follow the default naming convention
    // protected $table = 'tickets'; // Only necessary if the table name is not plural

    // Define the fillable fields (columns you can mass-assign)
    protected $fillable = [
        'samaccountname',
        'title',
        'description',
        'attachment',
        'assigned_to',
        'priority',
        'category',
        'resolved_at',
        'notes',
        'status'
    ];
}
