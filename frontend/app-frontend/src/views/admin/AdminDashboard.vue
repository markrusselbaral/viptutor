<template>
  <AdminLayout>
    <header class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
      <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" @click="logout()">
        Logout
      </button>
    </header>

    <!-- Statistics -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <StatsCard title="Total Users" :value="counts.totalUsers" />
      <StatsCard title="Total Tasks" :value="counts.totaltasks" />
      <StatsCard title="Pending Tasks" :value="counts.pendingtasks" />
      <StatsCard title="Completed Tasks" :value="counts.completedtasks" />
    </section>

    <section class="mt-10">
      <UsersTable
        :users="users"
        @view-tasks="openTaskModal"
        @paginate="fetchDashboardData"
      />
    </section>

    <TasksModal :user="selectedUser" @close="selectedUser = null" />
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useTaskStore } from '@/stores/taskStore'
import AdminLayout from '@/layouts/AdminLayout.vue'
import StatsCard from '@/components/StatsCard.vue'
import UsersTable from '@/components/UsersTable.vue'
import TasksModal from '@/components/TaskModal.vue'
import { useAuthStore } from '@/stores/authStore'
import router from '@/router'

const authStore = useAuthStore()
const taskStore = useTaskStore()
const users = ref([])
const counts = ref([])
const selectedUser = ref(null)

const openTaskModal = (user) => {
  selectedUser.value = user
}

const fetchDashboardData = async (page = 1) => {
  await taskStore.fetchAllTasks(page)
  users.value = taskStore.tasks.users
  counts.value = taskStore.tasks.counts
}

const logout = () => {
    authStore.logout()
    router.push('/admin-login')
}

onMounted(fetchDashboardData)
</script>
