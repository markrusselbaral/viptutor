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
    <slot />
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const authStore = useAuthStore()
const router = useRouter()

const logoutUser = () => {
  authStore.logout()
  router.push('/login')
}
</script>
