<script>
    import { defineProps } from 'vue'
    import Create_panel from './Create_panel.vue';
    import Panel from './Panel.vue';
  import Create from '@/Components/Create.vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import Breadcrumb from '@/Components/Breadcrumb.vue';

    export default {
  components: {
    Panel,
    Create
  },
  // Otros datos y opciones del componente
};

const typeFather= 'Panel';
const routeFather= '/create_panel';
const href =route().current();
</script>

<script setup>
  defineProps({panels: Array})
</script>

<template class="bg-blue-600">
   <AppLayout title="Dashboard">
    <Breadcrumb title="Panels"></Breadcrumb>
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