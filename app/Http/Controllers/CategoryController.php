<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Panel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index($panelid){
        $panel = Panel::with('categories.tasks')->findOrFail($panelid);
        //dd($panel);
        $panelName = $panel -> name;
        $categories = $panel->categories;
        

        $panelid = intval($panelid); 
          return Inertia::render('Category/Category_index', [
            'categories' => $categories,
            'panelName' => $panelName,
            'panelid' => $panelid
          ]);
    }

    public function create(){
        return view('category.create_category');
    }

    //Save a task in a DB
    public function store(Request $request){
        
        $panelid = $request ->input('panelid');
        //validate date
        //same name
        Category::create(['name'=>$request ->input('name'),'panel_id'=> $panelid]);

        return Inertia::location(route('category', ['id' => $panelid]));
    }

    //Delete
    public function destroy($id)
    {
        $category = Category::find($id);
        $panelid = $category->panel_id;
        $category->delete();
            return Inertia::location(route('category', ['id' => $panelid]));
           
            
    }
}
