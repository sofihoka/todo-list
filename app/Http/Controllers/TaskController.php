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
        $task = Task::all()->orderBy('order', 'asc');
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
        $maxOrder = Task::where('category_id', $category)->max('order');
        if( $maxOrder == null){
            $maxOrder=1;
        }else{
            $maxOrder++;
        }
        Task::create(['description'=>$request->input('description'),
        'category_id'=>$category,
        'order'=>$maxOrder]);
        
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

    public function changeTaskCategory(Request $request)
    {
        $taskId = $request->input('task'); 
        $category_id = $request->input('category_id'); 
        $panelid = $request->input('panelid');

        $task = Task::find($taskId);
        $task_category =  $task->category_id;
        $task->category_id = $category_id;
        $task ->save();

        return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente' , 'category_id' => $task_category]);
        //return Inertia::location(route('category', ['id' => $panelid]));            

    }

    public function editOrderTask(Request $request)
    { //{ taskDragId: taskDragId, index : index,  taskDropId : taskDropId}
        $taskDragId = $request->input('taskDragId'); 
        $taskDropId = $request->input('taskDropId'); 
        $taskDrag = Task::find($taskDragId);
        $taskDrop = Task::find($taskDropId);

        $taskDropCreat = $taskDrop->created_at;
        $taskDragCreat= $taskDrag->created_at;

        $taskDrag->created_at = $taskDropCreat;
        $taskDrop->created_at = $taskDragCreat;
        $taskDrag ->save();
        $taskDrop ->save();

        return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente']);
    }

}
