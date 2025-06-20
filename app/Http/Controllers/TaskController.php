<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Panel;

class TaskController extends Controller
{
    //Mostrar todas las tareas
    public function index(){
        $tasks = Task::all()->orderBy('order', 'asc');
        return view('task.index', compact($tasks));
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
        $category_id= $task->category_id;
        
        $tasks = Task::where('category_id', $category_id)->orderBy('order', 'asc')->get();
        for ($i=$task->order; $i < count($tasks); $i++) { 
            $tasks[$i]->order = $tasks[$i]->order - 1;
            $tasks[$i]->save();
        }

        $task->delete();    

    }

    public function changeTaskCategory(Request $request)
    {
        $taskId = $request->input('task'); 
        $category_id = $request->input('category_id'); 
        $panelid = $request->input('panelid');
        $drogsTaskId = $request->input('drogsTaskId');
        $task = Task::find($taskId);
        $drogsTask = Task::find($drogsTaskId);
        
        $_order = $task->order;
        if($drogsTaskId !=null){
            $tasksNewCategory = Task::where('category_id',$drogsTask ->category_id)->orderBy('order', 'asc')->get();  
            for ($i=($drogsTask->order) - 1; $i < count($tasksNewCategory); $i++) { 
                $tasksNewCategory[$i]->order = $tasksNewCategory[$i]->order + 1;
                $tasksNewCategory[$i]->save();
            }
            $task->order = $drogsTask ->order;
        }else{
            //later make a another way
            $maxOrder = Task::where('category_id', $category_id)->max('order');
            if( $maxOrder == null){
                $maxOrder=1;
            }else{
                $maxOrder++;
            }
            $task->order = $maxOrder;
        }
        
        
        $tasksDrog = Task::where('category_id', $task->category_id)->orderBy('order', 'asc')->get();
        for ($i=$_order; $i < count($tasksDrog); $i++) { 
            $tasksDrog[$i]->order = $tasksDrog[$i]->order - 1;
            $tasksDrog[$i]->save();
        }
        $task_category =  $task->category_id;
        $task->category_id = $category_id;
        $task ->save();

        $panel = Panel::with([
            'categories' => function ($query) {
                $query->orderBy('order_category', 'asc')
                      ->with(['tasks' => function ($query) {
                          $query->orderBy('order', 'asc');
                      }]);
            }
        ])->findOrFail($panelid);
        
        $categories = $panel->categories;

        return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente' , 'categories' => $categories]);
        //return Inertia::location(route('category', ['id' => $panelid]));            

    }

    public function editOrderTask(Request $request)
    { //{ taskDragId: taskDragId, index : index,  taskDropId : taskDropId}
        // task: taskId, drogsTaskId : drogsTaskId, category_id: category, panelid : panelid 
        $taskDragId = $request->input('taskDragId'); 
        $taskDropId = $request->input('taskDropId'); 
        $categoryid = $request->input('categoryid');
        $taskDrag = Task::find($taskDragId);
        $taskDrop = Task::find($taskDropId);
        $taskDragOrder= $taskDrag->order;
        $taskDropOrder = $taskDrop->order;
        
        $category = Category::with('tasks')->findOrFail($categoryid);
        
        $category->load(['tasks' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);
        $tasks = $category->tasks;
        $taskDrag->order = $taskDropOrder;
        if($taskDragOrder>$taskDropOrder){
          for ($i=$taskDropOrder-1; $i < $taskDragOrder-1; $i++) { 
            $tasks[$i]->order = $tasks[$i]->order + 1;
            $tasks[$i]->save();
            }
        }{
            for ($i=$taskDragOrder; $i < $taskDropOrder; $i++) { 
                $tasks[$i]->order = $tasks[$i]->order - 1;
                $tasks[$i]->save();
            }
        }
        $taskDrag ->save();
        
         return response()->json(['success' => true, 'message' => 'Success order task','tasks' => $taskDrag]);
    }

}
