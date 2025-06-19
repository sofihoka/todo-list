<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive ,getCurrentInstance  } from 'vue'
import { useMotions } from '@vueuse/motion';
import { nextTick , ref,onMounted, onBeforeUnmount} from 'vue';
import { useMotion } from '@vueuse/motion';

console.log(window.location.origin)

const showForm = ref(false);
const addTaskForm = ref({ description: '' });
const colCategoryRefs =ref({})

const taskRefs = ref({});
const draggedTaskId = ref(null);
const lastTask = ref(null);

const destroy = (categoryid) =>{
    Inertia.delete(route('delete_category',categoryid))
}

const destroyTask = (id) =>{
    console.log(id);
    Inertia.delete(route('delete_task',id))
}

defineExpose({
    onDropTask
});

const props = defineProps({
    categoryid: {
    type: Number,
    default: null  
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
   default: null 
  },
  draggedTaskId: {
    type: Number,
   default: null  
  }
});

const form = reactive({
    description: '',
    categoryid: props.categoryid,
    panelid:props.panelid,
    tasks:props.tasks
})

function submit() {
  router.post('add_task', form)
};

let draggedIndex = null;

const emit = defineEmits(['dragsTask','drogsTask'])


const internalInstance = getCurrentInstance();
const axios = internalInstance.appContext.config.globalProperties.$axios;
axios.defaults.baseURL = 'http://127.0.0.1:8001/';
let categoryDrag = null;


    const startDrag = (index, task_id,category, event) =>{
        console.log("startDrag"+categoryDrag)
        //
        draggedTaskId.value = task_id;
        const clone = event.target.cloneNode(true);
        
        clone.style.position = 'absolute';
        clone.classList.add('opacity-100')
        
        document.body.appendChild(clone);
        event.dataTransfer.setDragImage(clone, 0, 0)
        emit('dragsTask', task_id)
     
        setTimeout(() => {
            document.body.removeChild(clone); // Eliminar el clon después de arrastrar
        }, 0);
        categoryDrag = category
        console.log("startDrag"+categoryDrag)
        draggedIndex = index;
    }

    function allPreventDrop(){
        Event.preventDefault();
    }

    function onDragOver(event,taskid,tasks,task_order) { 
        const taskDiv = taskRefs.value[taskid]
        taskDiv.classList.add('h-10')
        taskDiv.classList.add('bg-slate-300')
        taskDiv.classList.add('rounded-lg')   
        taskDiv.classList.add('ml-2')
        taskDiv.classList.add('mr-2')
        taskDiv.classList.add('mb-2')
        taskDiv.classList.add('mt-2')
        // console.log(taskDiv);
    
       event.preventDefault();
    }
    
    function ondragleave(taskid){
        const taskDiv = taskRefs.value[taskid];
            setTimeout(() => {
            taskDiv.classList.remove('h-10');
            
        taskDiv.classList.remove('bg-slate-300');
        taskDiv.classList.remove('rounded-lg');
        
            }, 300);
           // taskDiv.classList.remove('h-10');
         //  const taskDiv2 = taskRefs.value["task_"+taskid];
    }


function onDropTask(index,tasks,taskid, categoryid) {
    console.log(categoryid+'onDropTask/editOrderTask'+categoryDrag)
    if (draggedIndex !== null && draggedIndex !== index && categoryid == categoryDrag) {
        console.log(categoryid+'acaaa no'+categoryDrag)
        const draggedItem = tasks[draggedIndex]
        tasks.splice(draggedIndex, 1)
        tasks.splice(index, 0, draggedItem)
        axios.put('/category/editOrderTask', { taskDragId: draggedTaskId.value, index : index,  taskDropId : taskid, categoryid : categoryid}).then((response) => {
            console.log("Recurso actualizado con éxito", response.data)
            tasks = response.data.tasks 
            
            draggedTaskId.value = null
        }).catch((error) => {
            console.error("Error al actualizar el recurso: ", error)
        })
    }else{
        emit('drogsTask', taskid)        
    }
    draggedTaskId.value = null;
    draggedIndex = null
    categoryDrag=null
}

 let isToggleForm=false;
const toggleForm = () => {
    showForm.value = !showForm.value;
};

const handleClickOutside = (event) => {
    if (event.target.contains(addTaskForm.value)) {
        showForm.value = false;
    }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});

</script>

<template class="bg-slate-200" @dragover.prevent="allPreventDrop()">   
    <div :ref="(el) => ( colCategoryRefs[categoryid] = el)" class="h-scream min-h-screen">
        <div class="bg-slate-200  ml-5 mr-10 mb-10 mt-10 shadow-md rounded-lg min-w-60" style="height: fit-content" >
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
                <!-- @foreach($category->taskds as $task)   -->
                    <form v-for=" (task, index) in tasks" > 
                        <div                             
                            :key="task.id"
                            :class="[ 
                                draggedTaskId === task.id ? ' h-0 rounded-none opacity-0' : 'opacity-100',
                            
                                ]"
                                @dragstart="startDrag(index,task.id,categoryid,$event)"                
                                draggable="true"                           
                                @dragover.prevent="onDragOver($event,task.id,tasks,task.order)"
                                @drop="onDropTask(index,tasks, task.id, categoryid)"
                                @update="draggedTaskId = draggedTaskId"
                                >
                                <div 
                                @dragleave="ondragleave(task.id)"
                                :ref="(el) => ( taskRefs[task.id] = el)" :id="task.id"></div>   
                            <div class="bg-slate-100 taskList grid grid-cols-6 shadow-md rounded-lg mr-2 ml-2 mb-2 mt-2 pl-2 pb-2 pt-2">
                                <div class="col-span-5 text-cyan-950" >
                                    {{ task.description }}
                                    draggedTaskId={{ draggedTaskId }}
                                    taskID= {{ task.id }}
                                    <!--- 
                                    {{ task.order }}-->
                                </div>
                                <div class="place-self-end">
                                    <button @click="destroyTask(task.id)" class="text-stone-500 font-bold  rounded focus:outline-none focus:shadow-outline" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                        </svg>
                                    </button>
                                </div>    
                            </div>
                        </div>
                            <div ref="lastTask"></div>
                        </form>
                        <div class="h-1"></div>    
                <!--  @endforeach-->   
                <!-- Form to Add Task -->
                    <div ref="addTaskForm" class="ml-2 mr-2 mb-2 mt-2 hover:bg-slate-400 rounded-lg ">
                        <button v-if="!showForm" 
                                @click="toggleForm" class="pl-2 flex mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-stone-600 mt-2">
                                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                </svg>
                                <div class="text-stone-600 font-bold pt-2 mb-3 w-11/12 hover: text-stone-700">Add a Task</div></button>
                    </div>                       
                    <form  @submit.prevent="submit()" v-if="showForm">
                        <div class="flex ">
                            <textarea class="w-11/12 min-h-12 max-h-24 ml-2 mr-2 mb-2 mt-2 pl-2 pb-2 pt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y" v-model="form.description" placeholder="Task" onfocus="clearError()" ></textarea>
                        </div>                
                        <div class="ml-2 mr-2 mb-2 mt-2">
                            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Add
                            </button>
                        </div>
                    </form>         
                <!-- End Form to Add Task -->
        </div>
    </div>      
</template>

