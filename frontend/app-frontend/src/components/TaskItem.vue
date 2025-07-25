<template>
  <div>
    <div class="text-sm text-gray-400 mb-1">#{{ index + 1 }}</div>
    <transition name="fade" mode="out-in">
      <div :key="task.id" class="bg-white rounded-xl shadow p-4 flex justify-between items-center">
        <div class="flex items-start gap-4">
          <input type="checkbox" class="mt-1" :checked="task.status === 'completed'" @change="$emit('update', task.id, $event.target.checked)" />

          <div>
            <h3 :class="['text-lg font-medium', task.status == 'completed' ? 'line-through text-gray-400' : 'text-gray-800']">
              {{ task.title }}
            </h3>
            <p class="text-sm text-gray-500">{{ task.description }}</p>
            <span :class="['inline-block text-xs font-semibold mt-1 px-2 py-0.5 rounded-full', {
              'bg-green-100 text-green-600': task.priority === 'low',
              'bg-yellow-100 text-yellow-700': task.priority === 'medium',
              'bg-red-100 text-red-600': task.priority === 'high',
            }]">
              {{ task.priority.toUpperCase() }}
            </span>
          </div>
        </div>
        <div v-if="isAdmin">
          <button @click="$emit('delete', task.id)" class="text-red-500 hover:underline text-sm">
            Delete
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
defineProps(['task', 'index', 'isAdmin'])
defineEmits(['delete', 'update'])
</script>
