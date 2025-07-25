<template>
  <div class="p-25">
    <div class="flex items-center justify-between mb-4">
      <button
        @click="logoutUser"
        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
      >
        Logout
      </button>
    </div>
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-2xl font-semibold text-gray-800">Task Management</h2>
      <button
        @click="openModal"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
      >
        + Add Task
      </button>
    </div>
    <!-- Filters -->
    <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
      <select
        v-model="filters.status"
        class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto"
      >
        <option value="all">All Status</option>
        <option value="pending">Pending</option>
        <option value="completed">Completed</option>
      </select>

      <select
        v-model="filters.priority"
        class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto"
      >
        <option value="all">All Priority</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>

      <input
        v-model="filters.search"
        type="text"
        placeholder="Search tasks..."
        class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-auto"
      />

      <button
        @click="applyFilters"
        class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900"
      >
        Filter
      </button>
    </div>

    <!-- Task List -->
    <draggable v-model="tasks" item-key="id" class="space-y-4" ghost-class="opacity-40">
      <template #item="{ element: task, index }">
        <div>
          <div class="text-sm text-gray-400 mb-1">#{{ index + 1 }}</div>
          <transition name="fade" mode="out-in">
            <div
              :key="task.id"
              class="bg-white rounded-xl shadow p-4 flex justify-between items-center"
            >
              <div class="flex items-start gap-4">
                <input
                  type="checkbox"
                  class="mt-1"
                  :checked="task.status === 'completed'"
                  @change="updateTask(task.id, $event.target.checked)"
                />

                <div>
                  <h3
                    :class="[
                      'text-lg font-medium',
                      task.status == 'completed' ? 'line-through text-gray-400' : 'text-gray-800',
                    ]"
                  >
                    {{ task.title }}
                  </h3>
                  <p class="text-sm text-gray-500">{{ task.description }}</p>
                  <span
                    :class="[
                      'inline-block text-xs font-semibold mt-1 px-2 py-0.5 rounded-full',
                      {
                        'bg-green-100 text-green-600': task.priority === 'low',
                        'bg-yellow-100 text-yellow-700': task.priority === 'medium',
                        'bg-red-100 text-red-600': task.priority === 'high',
                      },
                    ]"
                  >
                    {{ task.priority.toUpperCase() }}
                  </span>
                </div>
              </div>
              <div v-if="isAdmin">
                <button @click="destroyTask(task.id)" class="text-red-500 hover:underline text-sm">
                  Delete
                </button>
              </div>
            </div>
          </transition>
        </div>
      </template>
    </draggable>

    <!-- Add Task Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl">
        <h3 class="text-xl font-semibold mb-4">Add Task</h3>
        <form @submit.prevent="addTask()" class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full border border-gray-300 rounded-lg px-4 py-2"
            />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea
              v-model="form.description"
              class="w-full border border-gray-300 rounded-lg px-4 py-2"
            ></textarea>
          </div>
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
          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="closeModal"
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
  </div>
</template>

<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import draggable from 'vuedraggable'
import { useTaskStore } from '@/stores/taskStore'
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router'

const taskStore = useTaskStore()
const authStore = useAuthStore()
const router = useRouter()
const showModal = ref(false)
const isAdmin = true
const tasks = ref([])

const form = ref({
  title: '',
  description: '',
  priority: 'low',
})

const filters = reactive({
  status: '',
  priority: '',
  search: '',
})

const fetchTasks = async () => {
  const query = {
    ...filters,
    status: filters.status === 'all' ? '' : filters.status,
    priority: filters.priority === 'all' ? '' : filters.priority,
  }
  await taskStore.fetchTasks(query)
  tasks.value = taskStore.tasksPerUser
}

// Add Task
const addTask = async () => {
  await taskStore.addTask(form.value)
  await fetchTasks()
  closeModal()
}

// Delete Task
const destroyTask = async (id) => {
  await taskStore.destroyTask(id)
  await fetchTasks()
}

// Modal controls
const openModal = () => {
  showModal.value = true
  form.value = { title: '', description: '', priority: 'low' }
}
const closeModal = () => {
  showModal.value = false
}

// Update Task
const updateTask = async (id, isCompleted) => {
  await taskStore.updateTask(id, { isCompleted: isCompleted })
  await fetchTasks()
}

// filters
const applyFilters = async () => {
  await fetchTasks()
}

const logoutUser =  () => {
  authStore.logout()
  router.push('/login')
  
}

// 🔁 Watch for drag-and-drop reorder changes
watch(
  tasks,
  async (newTasks) => {
    const sorted = newTasks.map((task, index) => ({
      id: task.id,
      order: index + 1,
    }))
    await taskStore.reorderTask(sorted ?? [])
  },
  { deep: true },
)

onMounted(fetchTasks)
</script>
