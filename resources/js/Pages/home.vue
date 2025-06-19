<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
   <AppLayout title="Dashboard">
    <div>
    <h1>Welcome to Inertia + Vue 3!</h1>
    <p>This is a page rendered using Inertia.js and Vue 3.</p>  <div>
    <h1>Welcome to Inertia + Vue 3!</h1>
    <p>This is a page rendered using Inertia.js and Vue 3.</p>
    <Welcome />
  </div>
  </div>
   </AppLayout>

</template>

<script>
export default {
  props: {
    // Aquí puedes recibir props desde Laravel
  },
};
</script>