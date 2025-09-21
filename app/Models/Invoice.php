<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice';
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'sub_total',
        'total_discount',
        'total_charge',
        'grand_total',
        'is_paid',
        'payment_type',
        'description',
        'invoice_datetime',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function invoice_product()
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id', 'id');
    }
}
