<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Panel;

class TaskController extends Controller
{
    //Mostrar todas las tareas
    public function index(){
        $task = Task::all();
        return view('task.index', compact(task));
    }

    //Mostrar el formulario para crear una nueva tarea
    public function create(){
        return view('task.create');
    }

    //Save a task in a DB
    public function store(Request $request){
    // Valide
    $category=$request->input('categoryid');
    /*$validated = $request->validate([
        'description' => 'required|string|max:500'// 'nullable' permite que description esté vacío
        , [
            'description.required' => 'The description field cannot be empty.',
        ]
    ]);*/
    $panelid = $request ->input('panelid');
        //Task::create($request->all());
        //dd($category);
        Task::create(['description'=>$request->input('description'),
                    'category_id'=>$category]);

        
        return Inertia::location(route('category', ['id' => $panelid]));
    }

    //Delete
    public function destroy($id)
    {
        //$panel = Panel::with('categories.tasks')->findOrFail($panelid);  
        $task = Task::find($id);
        $panelId = $task->category->panel->id ?? null;

        $task->delete();

        return Inertia::location(route('category', ['id' => $panelId]));          

    }

    //Delete
    public function changeTaskCategory(Request $request)
    {
        $taskId = $request->input('task'); 
        $category_id = $request->input('category_id'); 
        $panelid = $request->input('panelid');
        
        $task = Task::find($taskId);
        $task->category_id = $category_id;
        // Lógica adicional..


        return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente']);           

    }
}
