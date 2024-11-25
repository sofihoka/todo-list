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
        $panel->load(['categories.tasks' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);
        //dd($panel);
        /*$panel = Panel::where('id', $panelid)
        ->with(['categories'])
        ->with(['tasks']);*/

        $panelName = $panel -> name;
        $categories = $panel->categories;
        //$tasks = $panel->tasks;

        /*foreach ($categories as $key => $category) {
                dump($category->id);
        }
        //dd( $panel->$relations);*/

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

    public function store(Request $request){
        
        $panelid = $request ->input('panelid');
        //validate date
        //same name
        $maxOrder = Category::where('panel_id', $panelid)->max('order_category');
        if( $maxOrder == null){
            $maxOrder=1;
        }else{
            $maxOrder++;
        }
        Category::create(['name'=>$request ->input('name')
        ,'panel_id'=> $panelid,
        'order_category'=>$maxOrder]);

        return Inertia::location(route('category', ['id' => $panelid]));
    }

    //Delete
    public function destroy($id)
    {
        $category = Category::find($id);
        $panelid = $category->panel_id;

        $categories = Category::where('panel_id', $panelid)->orderBy('order_category', 'asc')->get();
        //dd($categories);
        for ($i=$category->order_category; $i < count($categories); $i++) { 
            $categories[$i]->order_category = $categories[$i]->order_category - 1;
            $categories[$i]->save();
        }

        $category->delete();
            return Inertia::location(route('category', ['id' => $panelid]));
           
            
    }
}
