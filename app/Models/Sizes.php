<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
    protected $table = 'sizes';
    protected $fillable = ['size'];

    public function items()
    {
        return $this->belongsToMany(Items::class, 'item_size', 'size_id', 'item_id')
                    ->withPivot('price') // Mengambil kolom tambahan 'price' dari pivot
                    ->withTimestamps();
    }
}
