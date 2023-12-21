<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_costumer',
        'medicines',
        'total_price',
        'user_id',
    ];

    protected $casts = [
        'medicines' => 'array',
    ];      

    public function user()
    {
        return $this->belongsTo
        (User::class);
    }
}
