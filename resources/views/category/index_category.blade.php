<!doctype html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
    <body class="bg-indigo-500 rounded">
    <div class="w-all py-4 px-6 shadow-md flex">
        <h1 class="text-xl font-semibold ">
            {{ $panel->name }}
        </h1>
    </div>
    <div class="flex">
        @foreach ($categories as $category)
            <div class="bg-slate-300 ml-10 mr-10 mb-10 mt-10 shadow-md rounded-lg w-2/12">
                <div class="grid grid-cols-6">
                    <div class="ml-2 mr-10 mb-5 mt-2 text-left font-semibold col-span-5" >
                        {{ $category->name }}
                    </div>
                    <!-- Form to Delete -->
                    <div class="align-top">
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE') <!-- DELETE -->
                            <button type="submit" class="text-stone-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-1 hover:stroke-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <!-- End Form to Delete -->    
                </div>
                    @foreach($category->tasks as $task)
                    <form action="{{ route('task.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE') <!-- DELETE -->
                        <div class="bg-slate-100 grid grid-cols-6  gap-2 mr-2 ml-2 mb-2 mt-2 pl-2 pb-2 pt-2 shadow-md rounded-lg">
                            <div class="col-span-5">
                                {{ $task->description }}
                            </div>
                            <div class="place-self-end">
                                <button type="submit" class="text-stone-500 font-bold  rounded focus:outline-none focus:shadow-outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                </button>
                            </div>    
                        </div>
                    </form>
                    @endforeach
                    <!-- Form to Add Task -->
                    <form action="{{ route('task.add', $category->id) }}" method="POST">
                    <input type="hidden" name="panel_id" value="{{ $panel->id}}">
                    @csrf
                        <div class="flex">
                            <textarea class="w-11/12 min-h-12 max-h-24 ml-2 mr-2 mb-2 mt-2 pl-2 pb-2 pt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y" name="description" placeholder="Task" onfocus="clearError()" ></textarea>
                        </div>                
                        <div class="ml-2 mr-2 mb-2 mt-2 ">
                            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Add
                            </button>
                            @error('description')
                                <div class="text-red-500 text-sm" id='description-error'>{{ $message }}</div>
                            @enderror
                        </div>
                    </form>                
                    <!-- End Form to Add Task -->
            </div>  
        @endforeach 
            <!--<a class="bg-slate-100 ml-2 mr-2 mt-10  mb-10 pl-2 pb-2 pt-2 pr-5 shadow-md rounded-lg transition hover:scale-110" type="button" href="/create_category">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg> add Category
            </a>   -->
            <div class="flex-center justify-center items-center place-items-center ml-2 mr-2 mt-8  mb-10 pl-2 pb-2 pt-2 pr-5">
                <form class="bg-slate-300 bg-slate-300 shadow-md rounded px-8 pt-6 pb-8 mb-4 rounded-lg" action="{{ route('new_category') }}" method="POST">
                @csrf             
                <input type="hidden" name="panel_id" value="{{ $panel->id}}">
                <div class="flex flex-row place-items-center">
                    <div  class="font-bold  pb-4   mr-1" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                    <div  class="font-bold  pb-4 " >Category</div>
                </div>
                <div class="mb-4 flex">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Name">
                </div>
                <!--<div class="mb-4">
                    <input class="size-64 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Description" type="text" placeholder="Description">
                </div-->
                <div class="flex items-center justify-between">
                    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Add
                    </button>
                </div>
                </form>            
            </div>
            
    </div>
    
    <div class="w-all py-4 px-6 flex">
        <a class="text-xl font-semibold" href="{{ route('panel.index_panel') }}">
            <-Back
        </a>
    </div>
    </body>
</html>
<script>
    function clearError() {
        // Elimina el mensaje de error cuando el usuario empieza a escribir
        const descriptionError = document.getElementById('description-error');
        if (descriptionError) {
            descriptionError.style.display = 'none';
        }
    }
</script>