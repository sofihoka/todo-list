
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3';

defineProps(['id', 'name'])

const form = useForm({
    id: null
})

const destroy = (id) =>{
    Inertia.delete(route('delete_panel',id))
}
</script>

<template>    
   <a :href="'/category/'+id" class="bg-purple-600 ml-10 mr-10 mb-10 mt-10 shadow-md  rounded-full size-32  cursor-pointer hover:bg-purple-400">
        <div class="grid grid-cols-6">
            <div class="ml-2 mb-5 mt-10  text-center text-xl font-semibold col-span-4 " >
                {{ name }}
            </div>
            <div class="align-top">
                <form   @click="destroy(id)">
                    <button type="submit" class=" mt-9 text-stone-200 hover:text-white-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-1 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </form>    
            </div>
        </div>
    </a>
</template>