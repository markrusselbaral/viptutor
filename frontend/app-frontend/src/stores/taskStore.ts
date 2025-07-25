import { defineStore } from 'pinia'
import { useTaskService } from '@/services/taskService'
import { ref } from 'vue'
import type { Task } from '@/types/task'

export const useTaskStore = defineStore('task', () => {
  const taskService = useTaskService()

  // Reactive state
  const tasksPerUser = ref([])
  const tasks = ref([])

  // Actions
  async function fetchAllTasks(pageNumber: Number) {
    tasks.value = await taskService.allTasks(pageNumber)
  }

  async function fetchTasks(filters : Object) {
    tasksPerUser.value = await taskService.tasks(filters)
  }

  async function addTask(task: Task) {
    return await taskService.addTask(task)
  }

  async function destroyTask(id : Number) {
    return await taskService.destroyTask(id)
  }

  async function reorderTask(orderNumber : object) {
    return await taskService.reorderTask(orderNumber)
  }

    async function updateTask(id : Number, isCompleted : object) {
    return await taskService.updateTask(id, isCompleted)
  }

  return {
    tasksPerUser,
    tasks,
    fetchAllTasks,
    fetchTasks,
    addTask,
    destroyTask,
    reorderTask,
    updateTask
  }
})
