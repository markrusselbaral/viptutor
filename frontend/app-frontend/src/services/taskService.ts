import { getTasks, getAllTasks, store, destroy, reorder, update } from '@/api/task'
import type { Task } from '@/types/task'

export function useTaskService() {
  async function tasks(filters : Object) {
    return await getTasks(filters)
  }

  async function allTasks(pageNumber: Number) {
    return await getAllTasks(pageNumber)
  }

  async function addTask(task: Task) {
    try {
      const response = await store(task)
      return {
        success: true,
        message: 'Register successful',
        errors: 'none',
      }
    } catch (error: any) {
      return {
        success: false,
        message: error.response?.data?.message || 'Register failed',
        errors: error.response?.data?.errors || 'Register failed',
      }
    }
  }

  async function destroyTask(id: Number) {
    return await destroy(id)
  }

  async function reorderTask(orderNumber: Object) {
    return await reorder({ order: orderNumber })
  }

  async function updateTask(id: Number, isCompleted: Object) {
  return await update(id, isCompleted )
}

  return {
    addTask,
    tasks,
    allTasks,
    destroyTask,
    reorderTask,
    updateTask
  }
}
