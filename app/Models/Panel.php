<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $fillable = ['name'];
    // Relación: Cada category pertenece a un Panel
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
