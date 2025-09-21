<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice_product';
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
