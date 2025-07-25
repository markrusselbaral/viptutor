<template>
  <div class="bg-white p-4 rounded-xl shadow">
    <h3 class="text-gray-700 font-medium mb-2">{{ title }}</h3>
    <p class="text-3xl font-bold text-blue-600">{{ value }}</p>
  </div>
</template>

<script setup>
defineProps(['title', 'value'])
</script>
