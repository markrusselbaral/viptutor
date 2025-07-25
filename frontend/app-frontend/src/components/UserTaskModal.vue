<template>
  <div
    v-if="modelValue"
    class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center"
  >
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl">
      <h3 class="text-xl font-semibold mb-4">Add Task</h3>
      <form @submit.prevent="$emit('submit')" class="space-y-4">
        <!-- Title -->
        <div>
          <label class="block text-sm font-medium mb-1">Title</label>
          <input
            v-model="form.title"
            type="text"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2"
          />
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-medium mb-1">Description</label>
          <textarea
            v-model="form.description"
            class="w-full border border-gray-300 rounded-lg px-4 py-2"
          ></textarea>
        </div>

        <!-- Priority -->
        <div>
          <label class="block text-sm font-medium mb-1">Priority</label>
          <select
            v-model="form.priority"
            class="w-full border border-gray-300 rounded-lg px-4 py-2"
          >
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="$emit('update:modelValue', false)"
            class="px-4 py-2 border rounded-lg text-gray-600"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
          >
            Add
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
  form: Object
})

defineEmits(['submit', 'update:modelValue'])
</script>
