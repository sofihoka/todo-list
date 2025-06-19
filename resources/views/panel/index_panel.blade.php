<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
    <body class="bg-yellow-500 rounded">
    <div class="w-all py-4 px-6 shadow-md">
        <h1 class="text-xl font-semibold ">
            Panels
        </h1>
    </div>
    <div class="flex">
        @foreach ($panels as $panel)
            <a type='button' href="{{ route('index_category', $panel->id) }}" class="bg-yellow-300 ml-10 mr-10 mb-10 mt-10 shadow-md  rounded-full size-32  cursor-pointer hover:bg-yellow-200">
                <div class="grid grid-cols-6">
                    <div class="ml-2 mb-5 mt-10  text-center text-xl font-semibold col-span-4 " >
                        {{ $panel->name }}sssss
                    </div>
                    <!-- Form to Delete -->
                    <div class="align-top">
                        <form action="{{ route('panel.destroy', $panel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE') <!-- DELETE -->
                            <button type="submit" class=" mt-9 text-stone-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-1 hover:stroke-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>    
                    </div>
                </div>
            </a> 
        @endforeach 
        <div class="bg-yellow-300 rounded-lg flex-center justify-center items-center place-items-center ml-2 mr-2 mt-8  mb-10 pl-2 pb-2 pt-2 pr-5">
            <form class="shadow-md px-8 pt-6 pb-8 mb-4" action="{{ route('create_panel') }}" method="POST">
                @csrf              
              <div class="flex flex-row place-items-center">
                <div  class="font-bold  pb-4   mr-1" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div  class="font-bold  pb-4 " >Panel</div>
              </div>
              <div class="mb-4 flex">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Name">
              </div>
              <!--<div class="mb-4">
                <input class="size-64 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Description" type="text" placeholder="Description">
              </div-->
              <div class="flex items-center justify-between">
                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                  Add
                </button>
              </div>
            </form>            
        </div>
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