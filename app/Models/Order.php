<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'address',
        'delivery_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'delivery_date' => 'date',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    /**
     * Check if the order is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the order is processing.
     */
    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    /**
     * Check if the order is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the order is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the order is paid.
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }
}
