<script>
    import { defineProps } from 'vue'
    import Create_panel from './Create_panel.vue';
    import Panel from './Panel.vue';
  import Create from '@/Components/Create.vue';
  import AppLayout from '@/Layouts/AppLayout.vue';


    export default {
  components: {
    Panel,
    Create
  },
  // Otros datos y opciones del componente
};

const typeFather= 'Panel';
const routeFather= '/create_panel';
</script>

<script setup>
  defineProps({panels: Array})
</script>

<template class="bg-blue-600">
   <AppLayout title="Dashboard">
      <div class="w-all py-4 px-6 shadow-md flex bg-zinc-300	">
            <h1 class="text-xl font-semibold ">
              Panels
            </h1>
      </div>
      <div class="bg-indigo-500">
        <div class="flex min-h-screen  bg-indigo-500	overflow-auto">
          <Panel
          v-for="panel in panels"
                  :id="panel.id"
                  :name="panel.name"
          ></Panel>  
          <Create :type="typeFather" :route="routeFather"/>
        </div>
      </div>  
    </AppLayout>
</template>