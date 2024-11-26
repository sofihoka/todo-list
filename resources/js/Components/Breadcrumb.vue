<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: String,
    title: String
});

const href =route().current();
</script>


<template>
    <Link :href="href" class=" text-xl font-semibold text-white">
        <span class=" py-4 px-6 shadow-md flex bg-blue-950 rounded-t-lg">
            {{ title }}
        </span>
    </Link>
</template>