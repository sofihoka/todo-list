<script>
    import { defineProps } from 'vue'
    import Create from '@/Components/Create.vue';
    import Categories from './Categories.vue';
    import { Link } from '@inertiajs/vue3';
    import Banner from '@/Components/Banner.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';

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
const routeFather= '/create_category';
defineProps(['categories'])

    let draggedIndex = null;
    let isTask =false;
    const startDrag = (index) =>{
      console.log("startDrag: "+index);
      draggedIndex = index;
    }

    function onDragOver(event) {
      console.log("index");
      event.preventDefault();
    }

    function onDropTask(){
      console.log("acaaaaa")
      isTask=true;
    } 

function onDrop(index,categories) {
  if (draggedIndex !== null && draggedIndex !== index && isTask==false) {
    const draggedItem = categories[draggedIndex];
    categories.splice(draggedIndex, 1); 
    categories.splice(index, 0, draggedItem); // Insertarlo en la nueva posición
  }
  draggedIndex = null;
  isTask =false;
}


</script>

<script setup>
  defineProps({categories: Array,　panelName　:String, panelid :Number, tasks: Array})
</script>

<template>
  <AppLayout title="Dashboard">
  <div class="overflow-auto w-full py-4 px-6 shadow-md flex bg-zinc-300	">
      <h1 class="text-xl font-semibold ">
        {{panelName}}
      </h1>
  </div>
  <div class="min-h-screen  bg-indigo-500	overflow-auto" >
    <div class="flex" >
      <Categories :panelid="panelid"
      :tasks="category.tasks"
      v-for="(category, index) in categories"
              :categoryid="category.id"
              :name="category.name"
              draggable="true"
              @dragstart="startDrag(index)"
              @dragover.prevent="onDragOver"
              @drop="onDrop(index,categories)"
      ></Categories>    
      <Create :type="typeFather" :route="routeFather" :panelid="panelid" /> 
    </div>
  </div>  
</AppLayout>
</template>