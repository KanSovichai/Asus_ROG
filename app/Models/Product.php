<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name',
        'category',
        'price',
        'image',
        'description',
        'cpu',
        'ram',
        'gpu',
        'display',
        'stock',
        'imag_url',
    ];
}
