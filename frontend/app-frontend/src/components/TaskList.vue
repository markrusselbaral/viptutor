<template>
  <draggable
    :model-value="tasks"
    item-key="id"
    class="space-y-4"
    ghost-class="opacity-40"
    @update:model-value="onReorder"
  >
    <template #item="{ element: task, index }">
      <TaskItem
        :task="task"
        :index="index"
        :isAdmin="isAdmin"
        @delete="onDelete"
        @update="onUpdate"
      />
    </template>
  </draggable>
</template>

<script setup>
import draggable from 'vuedraggable'
import TaskItem from './TaskItem.vue'

const props = defineProps({
  tasks: {
    type: Array,
    required: true,
  },
  isAdmin: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['delete', 'update', 'reorder'])

const onDelete = (id) => emit('delete', id)
const onUpdate = (id, isCompleted) => emit('update', id, isCompleted)
const onReorder = (newTasks) => emit('reorder', newTasks)
</script>
