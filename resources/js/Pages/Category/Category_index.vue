<script setup >
    import { defineProps, ref } from 'vue'
    import Create from '@/Components/Create.vue';
    import Categories from './Categories.vue';
    import { Link } from '@inertiajs/vue3';
    import Banner from '@/Components/Banner.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Breadcrumb from '@/Components/Breadcrumb.vue';

    
    const components = {
      Create,
      Categories
    }

  const props = defineProps({categories: Array,　panelName　:String, panelid :Number, tasks: Array })

  const draggedTaskId = ref(null)
  
  const categoriesList = ref([])
  categoriesList.value = props.categories

  const typeFather= 'Category';
  const routeFather= '/create_category'

    let draggedIndex = null
    let isTask =false
    let taskId = null
    let drogsTaskId = null

    const dragsTask = (task_id) =>{
      console.log("holaaaa")
      draggedTaskId.value= task_id
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
  
  console.log('onDrop')
  if (draggedIndex !== null && draggedIndex !== index && isTask==false) {
    const draggedItem = categories[draggedIndex]
    categories.splice(draggedIndex, 1)
    categories.splice(index, 0, draggedItem)
    axios.put('/category/editCategoryOrder', {category : category,categoryDrag : categoryDrag }).then((response) => {
        //categories = response.data.categories
       // categoriesList.value = categories
        }).catch((error) => {
        console.error("Error: ", error);
        });
  }else{ 
    /*changed the "category" of the "tasks" */ 
    if(category != categoryDrag){
      axios.put('/category/editCategoryTask', { task: taskId, drogsTaskId : drogsTaskId, category_id: category, panelid : panelid }).then((response) => {
        categories = response.data.categories
        categoriesList.value = categories
        }).catch((error) => {
        console.error("Error: ", categoryDrag+" //// "+category)
        });
        categoryDrag = null
    }else{
      console.log('Else  /category/editCategoryTask')
      /*drop in the same category but outside <Categories> @drop="onDropTask(index,tasks, task.id, categoryid)">*/
   

    }


  }

  //categoryDrag = null;
  draggedIndex = null;
  drogsTaskId = null;
  taskId = null;
  isTask =false;
}

</script>


<template>
  <AppLayout title="Dashboard">
    <Breadcrumb :title=panelName></Breadcrumb>
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500	overflow-auto">
      <div class="flex max-sm:flex-col " draggable="true">
        {{ draggedTaskId }}
        <Categories :panelid="panelid"
        :tasks="category.tasks"
        v-for="(category, index) in categoriesList"
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