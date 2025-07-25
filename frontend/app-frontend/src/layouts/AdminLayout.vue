<template>
  <div class="min-h-screen bg-gray-100 flex flex-col md:flex-row">
    <Sidebar />
    <main class="flex-1 p-6 overflow-y-auto">
      <slot />
    </main>
  </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue'
</script>
