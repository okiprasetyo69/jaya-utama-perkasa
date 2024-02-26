<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_code',
        'product_name', 
    ];

    public function categories(){
        return $this->belongsTo(Categories::class, 'category_id','id');
    }
}
