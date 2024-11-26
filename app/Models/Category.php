<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','panel_id','order_category'];
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }


}
