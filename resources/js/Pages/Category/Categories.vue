<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive ,getCurrentInstance  } from 'vue'
import { useMotions } from '@vueuse/motion';
import { nextTick , ref,onMounted } from 'vue';
import { useMotion } from '@vueuse/motion';


const taskRefs = ref({});

const destroy = (categoryid) =>{
    console.log(categoryid);
    Inertia.delete(route('delete_category',categoryid))
}

const destroyTask = (id) =>{
    console.log(id);
    Inertia.delete(route('delete_task',id))
}

const props = defineProps({
    categoryid: {
    type: Number,
    default: null  // Esto permite que panelId sea panelid
  },
  description:{
    type: String,
    default: null
  },
  name:{
    type: String,
    default: null
  },
  tasks:{
    type: Array,
    default: null
  },
  panelid: {
    type: Number,
   default: null  // Esto permite que  sea panelid
  }
});

const form = reactive({
    description: '',
    categoryid: props.categoryid,
    panelid:props.panelid
})

function submit() {
  router.post('add_task', form)
};

let draggedIndex = null;

const emit = defineEmits(['dragsTask','drogsTask'])

// Ahora puedes usar axios a través de app.config.globalProperties
const internalInstance = getCurrentInstance();
const axios = internalInstance.appContext.config.globalProperties.$axios;
let taskDragId = null
let categoryDrag = null;




    const startDrag = (Event,index, task_id, categoryid) =>{
        const taskDiv = taskRefs.value[`11`]; // Accedemos a la referencia dinámica
       //console.log(taskDiv);
        //Event.currentTarget.classList.add('h-5'),

       // const taskDiv = this.$refs['task_' + task_id];
      
        //console.log(taskDiv); // Muestra el div

         // taskDiv.classList.add('h-5'); 

        // Usar un elemento fantasma vacío para evitar el efecto translúcido

        taskDragId = task_id
        categoryDrag = categoryid
        //console.log("drap category" +category_id)
        emit('dragsTask', task_id)
     // console.log("startDrag: "+index);
      draggedIndex = index;
    }

    function onDragOver(event,taskid) { 
        const taskDiv = taskRefs.value[taskid];
        console.log(taskDiv);
        taskDiv.classList.add('h-10'); 
        event.preventDefault();
    }

    
    function ondragenter(taskid){
        const taskDiv = taskRefs.value[taskid];
        const taskDiv2 = taskRefs.value["task_"+taskid];
        console.log(taskDiv);
        taskDiv2.classList.add('bg-red-200'); 
            taskDiv.classList.add('h-10'); 
    }
    function ondragleave(taskid){
        const taskDiv = taskRefs.value[taskid];
            console.log("dragleave");
            taskDiv.classList.remove('h-10'); 
    }


    

   
function onDrop(index,tasks,order,taskid, categoryid) {
    if (draggedIndex !== null && draggedIndex !== index && categoryid == categoryDrag) {
        const draggedItem = tasks[draggedIndex]
        tasks.splice(draggedIndex, 1)
        tasks.splice(index, 0, draggedItem)
        
        axios.put('/category/editOrderTask', { taskDragId: taskDragId, index : index,  taskDropId : taskid, categoryid : categoryid}).then((response) => {
            console.log("Recurso actualizado con éxito", response.data)
            Inertia.visit(window.location.href);
        }).catch((error) => {
            console.error("Error al actualizar el recurso: ", error)
        })
    }else{
        emit('drogsTask', taskid)        
    }

  draggedIndex = null
  categoryDrag=null
}

 

  
</script>

<template class="bg-slate-200">   
    <div class="bg-slate-200  ml-5 mr-10 mb-10 mt-10 shadow-md rounded-lg min-w-48" style="height: fit-content" >
        <div class="grid grid-cols-6  ">
            <div class="ml-2 mr-10 mb-5 mt-2 text-left font-semibold col-span-5 text-cyan-950"  >
                {{ name }}
            </div>
            <!-- Form to Delete -->
            <div class="align-top">
                <div @click="destroy(categoryid)">
                    <button type="submit" class="text-stone-500 font-bold py-2 pl-50 rounded focus:outline-none focus:shadow-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-1 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Form to Delete -->    
        </div>
            <!-- @foreach($category->taskds as $task)-->
                <form v-for=" (task, index) in tasks" >
                        <div :ref="(el) => ( taskRefs['task_'+task.id] = el)"
                            draggable="true"
                            @dragstart="startDrag($event,index,task.id,categoryid)"
                             @dragleave="ondragleave(task.id)"
                            @dragover.prevent="onDragOver($event,task.id)"
                            @drop="onDrop(index,tasks,task.order, task.id, categoryid)"class="bg-slate-100 taskList grid grid-cols-6  gap-2 mr-2 ml-2 mb-2 mt-2 pl-2 pb-2 pt-2 shadow-md rounded-lg">
                            <div class="col-span-5 text-cyan-950">
                                {{ task.description }}- 
                                {{ task.order }}
                            </div>
                            <div class="place-self-end">
                                <button @click="destroyTask(task.id)" class="text-stone-500 font-bold  rounded focus:outline-none focus:shadow-outline" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                </button>
                            </div>    
                        </div>
                        <div :ref="(el) => ( taskRefs[task.id] = el)" :id="task.id"></div>
                </form>
            <!--  @endforeach-->   
            <!-- Form to Add Task -->
            <form  @submit.prevent="submit()" >
                <div class="flex ">
                    <textarea class="w-11/12 min-h-12 max-h-24 ml-2 mr-2 mb-2 mt-2 pl-2 pb-2 pt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y" v-model="form.description" placeholder="Task" onfocus="clearError()" ></textarea>
                </div>                
                <div class="ml-2 mr-2 mb-2 mt-2">
                    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Add
                    </button>
                    <!--  @error('description')
                        <div class="text-red-500 text-sm" id='description-error'>{{ $message }}</div>
                    @enderror-->  
                </div>
            </form>                
            <!-- End Form to Add Task -->
    </div>  
</template>

