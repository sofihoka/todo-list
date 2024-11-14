<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PanelController extends Controller
{
    //Mostrar todas las tareas
    public function index(){
        $panels = Panel::all();
        return Inertia::render('Panel/Panel_index', [
            'panels' => $panels
          ]);
    }

    //Mostrar el formulario para crear una nueva tarea
    public function create(){
        return view('task.create');
    }

    //Save a task in a DB
    public function store(Request $request){
    // Valide
    $panel_name = $request->input('name');   
    $panel =Panel::create(['name'=>$panel_name]);
    $id = $panel->id;
    return redirect() ->route('category', [
        'id' => $id
        ]);
    }

    //Delete
    public function destroy($id)
    {
        $panel = Panel::find($id);
        if ($panel) {

            $panel->delete();

            return Inertia::render('Panel/Panel_index');
        }
    }
}
