<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Relación: Cada tarea pertenece a una categoria
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }

    protected $fillable = ['name','panel_id'];

}
