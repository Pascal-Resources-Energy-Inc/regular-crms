<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailCharge extends Model
{
    protected $table = 'order_detail_charges';
    
    protected $fillable = [
        'order_detail_id',
        'name',
        'amount'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2'
    ];
    
    /**
     * Get the order detail that owns this charge
     */
    public function orderDetail()
    {
        return $this->belongsTo('App\OrderDetail', 'order_detail_id');
    }
}
