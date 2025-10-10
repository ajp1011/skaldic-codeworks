<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-4">
        Hello from Vue.js + TypeScript!
      </h1>
      <p class="text-gray-600 mb-4">
        This is your portfolio website running with:
      </p>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Laravel 12.x</li>
        <li>Vue.js 3</li>
        <li>TypeScript</li>
        <li>Tailwind CSS</li>
        <li>Vite (with hot reload)</li>
      </ul>
      <div class="mt-6">
        <button 
          @click="incrementCounter"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Click me! ({{ counter }})
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const counter = ref(0);

const incrementCounter = () => {
  counter.value++;
};
</script>

<style scoped>
/* Component-specific styles can go here */
</style>

