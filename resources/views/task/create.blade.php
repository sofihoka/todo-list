<!DOCTYPE html>
<html lang="en">
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
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 size-100">              
              <div class="flex flex-row place-items-center">
                <div  class="font-bold  pb-4   mr-1 bg-blue-400 " >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>

                </div>
                <div  class="font-bold  pb-4 bg-red-400" >TasK</div>
              </div>
              <div class="mb-4 flex">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Title" type="text" placeholder="Title">
              </div>
              <div class="mb-4">
                <input class="size-64 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Description" type="text" placeholder="Description">
              </div>
              <div class="flex items-center justify-between">
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                  Add
                </button>
              </div>
            </form>            
          </div>
   
    </body>
</html>