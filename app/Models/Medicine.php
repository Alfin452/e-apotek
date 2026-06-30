<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'storage_id',
        'stock',
        'min_stock',
        'type_id',
        'unit_id',
        'category_id',
        'expired_date',
        'description',
        'purchase_price',
        'selling_price',
        'supplier_id',
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
