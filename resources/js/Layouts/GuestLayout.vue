<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col items-center pt-12 sm:pt-6 bg-gray-100">
        <div
            class="w-full sm:max-w-lg mt-1 px-6 py-12 bg-white shadow-md overflow-hidden sm:rounded-sm"
        >
            <slot />
        </div>
    </div>
</template>
