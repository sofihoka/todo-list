<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['description','category_id','order'];



    //Cada tarea pertenece a un categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     // Relación con las etiquetas
     public function tags()
     {
         return $this->belongsToMany(Tag::class);
     }
}
