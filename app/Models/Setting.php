<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function default_customer()
    {
        return $this->hasOne(Customer::class, 'id', 'default_customer_id');
    }
}
