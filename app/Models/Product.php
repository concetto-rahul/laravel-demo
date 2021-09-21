<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku_code',
        'description',
        'added_by',
        'update_by',
        'imageviewfile',
    ];

    protected $hidden = [
        'added_by',
        'update_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'update_by','id');
    }
}
