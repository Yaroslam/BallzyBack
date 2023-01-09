<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersApi extends Model
{
    use HasFactory;
    protected $table = 'OrdersApi';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'order_status',
        "executor",
        "customer",
        "shoes"
    ];


    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function shoes()
    {
        return $this->belongsTo(Shoe::class, 'shoe_id');
    }



}
