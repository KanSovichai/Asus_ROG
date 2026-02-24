<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'ordered_items';
    protected $fillable = [
        'user_id',
        'product_id',
        'full_name',
        'quantity',
        'status',
        'total_price',
        'payment_method',
        'phone_number',
        'address',
        'City',
        'province/state',
        'notes',
    ];
}
