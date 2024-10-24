<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sizes;

class Items extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'items_name',
        'items_price',
        'category_id'
    ];

    public function sizes()
    {
        return $this->belongsToMany(Sizes::class, 'item_size', 'item_id', 'size_id')
                    ->withPivot('price') // Mengambil kolom tambahan 'price' dari pivot
                    ->withTimestamps();
    }
}
