<template>
  <div
    v-if="user"
    class="fixed inset-0 flex items-center justify-center z-50"
    style="background-color: rgba(0, 0, 0, 0.3)"
  >
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg p-6 relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl"
        @click="$emit('close')"
      >
        &times;
      </button>
      <h3 class="text-xl font-semibold text-gray-800 mb-4">Tasks for {{ user.name }}</h3>
      <div v-if="user.tasks.length > 0" class="space-y-4 max-h-[400px] overflow-y-auto">
        <div
          v-for="task in user.tasks"
          :key="task.id"
          class="p-4 bg-gray-100 rounded-lg shadow-sm"
        >
          <div class="flex justify-between items-center">
            <h4 class="font-semibold">{{ task.title }}</h4>
            <span
              class="text-xs px-2 py-1 rounded-full"
              :class="{
                'bg-yellow-200 text-yellow-800': task.status === 'pending',
                'bg-green-200 text-green-800': task.status === 'completed',
              }"
            >
              {{ task.status }}
            </span>
          </div>
          <p class="text-sm text-gray-600 mt-1">{{ task.description }}</p>
          <span
            class="inline-block mt-2 text-xs font-medium px-2 py-1 rounded bg-blue-100 text-blue-700"
          >
            Priority: {{ task.priority }}
          </span>
        </div>
      </div>
      <div v-else class="text-gray-500 text-center py-6">No tasks available.</div>
    </div>
  </div>
</template>

<script setup>
defineProps(['user'])
</script>
