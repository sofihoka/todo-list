<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
    <body>
      <!-- Main Content 
    <main class="flex max-w-screen-lg	">
       Sidebar 
      <aside class="col-span-1 bg-blue-50 p-4 rounded shadow-md">
            <h2 class="font-semibold text-lg">Sidebar</h2>
            <ul>
                <li><a href="#" class="text-blue-500 hover:underline">Link 1</a></li>
                <li><a href="#" class="text-blue-500 hover:underline">Link 2</a></li>
            </ul>
        </aside> -->        
        <div class="flex-center justify-center items-center place-items-center bg-yellow-400">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('new_category') }}" method="POST">
            @csrf              
              <div class="flex flex-row place-items-center">
                <div  class="font-bold  pb-4   mr-1 bg-blue-400" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div  class="font-bold  pb-4 bg-red-400" >Category</div>
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
   
    </body>
</html>