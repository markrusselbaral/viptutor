import axiosInstance from './index'
import type { Task } from '@/types/task'

export async function getTasks(filters : Object) {
  const { data } = await axiosInstance.get('/tasks', { params: filters })
  return data
}

export async function getAllTasks(pageNumber: Number) {
  const { data } = await axiosInstance.get(`/all-tasks?page=${pageNumber}`)
  return data
}

export async function store(task: Task) 
{
  const { data } = await axiosInstance.post('/tasks', task)
  return data
}

export async function destroy(id : Number) 
{
  const { data } = await axiosInstance.delete(`/tasks/${id}`)
  return data
}

export async function reorder(orderNumber : Object) 
{
  const { data } = await axiosInstance.post('/tasks/reorder', orderNumber)
  return data
}

export async function update(id: Number, payload: object) {
  const { data } = await axiosInstance.put(`/tasks/${id}`, payload)
  return data
}
