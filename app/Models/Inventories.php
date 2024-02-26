<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventories extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_number',
        'inventory_date', 
        'inventory_reference_number',
        'inventory_notes',
        'products',
    ];
}
