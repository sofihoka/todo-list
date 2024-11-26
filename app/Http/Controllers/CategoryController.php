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
        $panel = Panel::with([
            'categories' => function ($query) {
                $query->orderBy('order_category', 'asc')
                      ->with(['tasks' => function ($query) {
                          $query->orderBy('order', 'asc');
                      }]);
            }
        ])->findOrFail($panelid);
        
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
        for ($i=$category->order_category; $i < count($categories); $i++) { 
            $categories[$i]->order_category = $categories[$i]->order_category - 1;
            $categories[$i]->save();
        }

        $category->delete();

    }
   
    public function editCategoryOrder(Request $request){
        //categories: categories, panelid : panelid,category : category,categoryDrag : categoryDrag
        $categoryId = $request->input('category');
        $categoryDragId = $request->input('categoryDrag');
        $category = Category::find($categoryId);
        $categoryOrder = $category->order_category;
       
        $categoryDrag= Category::find($categoryDragId);
        $categoryDragOrder = $categoryDrag->order_category;

        $category->order_category =  $categoryDragOrder;
        $categoryDrag->order_category = $categoryOrder;

        $category->save();
        $categoryDrag ->save();

        return response()->json(['success' => true, 'message' => 'success!']);
    
    }
}
