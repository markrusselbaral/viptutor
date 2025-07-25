<template>
  <form @submit.prevent="handleLogin" class="p-8 rounded shadow w-full max-w-md bg-white">
    <h1 class="text-2xl font-bold mb-6 text-center"><slot /></h1>

    <div
      v-if="errorMessage"
      class="flex justify-center mb-4 p-3 bg-red-50 text-red-700 text-sm rounded border border-red-200"
    >
      {{ errorMessage }}
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input
        type="email"
        v-model="loginCredentials.email"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="admin@example.com"
      />
    </div>

    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input
        type="password"
        v-model="loginCredentials.password"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="••••••••"
      />
    </div>

    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
      Login
    </button>

    <!-- Register Link -->
    <p class="text-center text-sm text-gray-600 mt-4">
      Don't have an account?
      <RouterLink to="/register" class="text-blue-600 hover:underline">
        Register here
      </RouterLink>
    </p>
  </form>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import type { LoginCredentials } from '@/types/auth'

const router = useRouter()
const authStore = useAuthStore()
const errorMessage = ref('')

const loginCredentials = reactive<LoginCredentials>({
  email: '',
  password: '',
})

const handleLogin = async () => {
  const login = await authStore.login(loginCredentials)
  if (login.success) {
    router.push('/tasks')
  } else {
    errorMessage.value = login.message
  }
}
</script>
