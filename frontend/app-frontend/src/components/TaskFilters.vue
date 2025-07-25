<template>
  <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
    <select v-model="filters.status" class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto">
      <option value="all">All Status</option>
      <option value="pending">Pending</option>
      <option value="completed">Completed</option>
    </select>

    <select v-model="filters.priority" class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto">
      <option value="all">All Priority</option>
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>

    <input v-model="filters.search" type="text" placeholder="Search tasks..." class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto" />

    <button @click="$emit('filter')" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">
      Filter
    </button>
  </div>
</template>

<script setup>
defineProps(['filters'])
defineEmits(['filter'])
</script>
