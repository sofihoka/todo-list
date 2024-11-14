<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

defineProps(['type'])
const form = reactive({
    name: null
})

function submit() {
  router.post('/create_panel', form)
};
</script>

<template>
    <!---->
    <form @submit.prevent="submit" class="shadow-md px-8 pt-6 pb-8 mb-4" >
    <div class="flex flex-row place-items-center">
        <div  class="font-bold  pb-4   mr-1" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
        </div>
        <div  class="font-bold  pb-4 " >{{type}}</div>
    </div>
    <div class="mb-4 flex">
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="form.name" placeholder="Name">
    </div>
    <!--<div class="mb-4">
        <input class="size-64 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Description" type="text" placeholder="Description">
    </div-->
    <div class="flex items-center justify-between">
        <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" >
        Add
        </button>
    </div>
    </form> 
</template>
