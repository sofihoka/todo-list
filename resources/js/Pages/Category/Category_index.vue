<script>
    import { defineProps } from 'vue'
    import Create from '@/Components/Create.vue';
    import Categories from './Categories.vue';
    import { Link } from '@inertiajs/vue3';
    import Banner from '@/Components/Banner.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Breadcrumb from '@/Components/Breadcrumb.vue';

    export default {
    components: {
      Create,
      Categories
    },

    methods: {
    startDrag(evt, item) {
      evt.dataTransfer.dropEffect = 'move'
      evt.dataTransfer.effectAllowed = 'move'
      evt.dataTransfer.setData('itemID', item.id)
    },
    onDrop(evt, list) {
      const itemID = evt.dataTransfer.getData('itemID')
      const item = this.items.find((item) => item.id == itemID)
      item.list = list
    },
  }
  // Otros datos y opciones del componente
};

const typeFather= 'Category';
const routeFather= '/create_category'

    let draggedIndex = null
    let isTask =false
    let taskId = null
    let drogsTaskId = null

    const dragsTask = (task_id) =>{
      isTask=true;
      taskId = task_id;
    }

    const drogsTask = (drogsTask_id) =>{
      drogsTaskId = drogsTask_id;
    }

    let categoryDrag= null;
    const startDrag = (index, categoryDrag1) =>{
      draggedIndex = index;
      categoryDrag = categoryDrag1;
    }

    function onDragOver(event) {
      event.preventDefault();
    }


function onDrop(index,categories,category,panelid) {
  if (draggedIndex !== null && draggedIndex !== index && isTask==false) {
    const draggedItem = categories[draggedIndex];
    categories.splice(draggedIndex, 1); 
    categories.splice(index, 0, draggedItem); // Insertarlo en la nueva posición
  }else{ 
    /*changed the "category" of the "tasks" */ 
    if(category != categoryDrag){
      axios.put('/category/editCategoryTask', { task: taskId, drogsTaskId : drogsTaskId, category_id: category, panelid : panelid }).then((response) => {
        console.log("Recurso actualizado con éxito", response.data);
        Inertia.visit(window.location.href);
        }).catch((error) => {
        console.error("Error al actualizar el recurso: ", error);
        });
    }


  }

  categoryDrag = null;
  draggedIndex = null;
  drogsTaskId = null;
  taskId = null;
  isTask =false;
}


</script>

<script setup>
  defineProps({categories: Array,　panelName　:String, panelid :Number, tasks: Array })
</script>

<template>
  <AppLayout title="Dashboard">
    <Breadcrumb :title=panelName></Breadcrumb>
    <div class="min-h-screen  bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500	overflow-auto" >
      <div class="flex max-sm:flex-col ">
        <Categories :panelid="panelid"
        :tasks="category.tasks"
        v-for="(category, index) in categories"
                :categoryid="category.id"
                :name="category.name"
                draggable="true"
                @dragsTask="dragsTask"
                @drogsTask="drogsTask"
                @dragstart="startDrag(index, category.id)"
                @dragover.prevent="onDragOver"
                @drop="onDrop(index,categories, category.id,panelid)"
        ></Categories>    
        <Create :type="typeFather" :route="routeFather" :panelid="panelid" /> 
      </div>
    </div>  
  </AppLayout>
</template>