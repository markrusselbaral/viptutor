<template>
  <form @submit.prevent="handleRegister" class="p-8 rounded shadow w-full max-w-md bg-white">
    <h1 class="text-2xl font-bold mb-6 text-center">Task Management System</h1>

    <!-- Name -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
      <input
        type="text"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="John Doe"
        v-model="registerCredentials.name"
      />
      <p v-if="fieldErrors.name" class="text-sm text-red-600 mt-1">{{ fieldErrors.name[0] }}</p>
    </div>

    <!-- Email -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input
        type="email"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="admin@example.com"
        v-model="registerCredentials.email"
      />
      <p v-if="fieldErrors.email" class="text-sm text-red-600 mt-1">{{ fieldErrors.email[0] }}</p>
    </div>

    <!-- Password -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input
        type="password"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="••••••••"
        v-model="registerCredentials.password"
      />
      <p v-if="fieldErrors.password" class="text-sm text-red-600 mt-1">{{ fieldErrors.password[0] }}</p>
    </div>

    <!-- Confirm Password -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
      <input
        type="password"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
        placeholder="••••••••"
        v-model="registerCredentials.c_password"
      />
      <p v-if="fieldErrors.c_password" class="text-sm text-red-600 mt-1">{{ fieldErrors.c_password[0] }}</p>
    </div>

    <!-- Submit -->
    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
      Sign up
    </button>

    <!-- Login Link -->
    <p class="text-center text-sm text-gray-600 mt-4">
      Already have an account?
      <RouterLink to="/login" class="text-blue-600 hover:underline">Sign in here</RouterLink>
    </p>
  </form>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import type { RegisterCredentials } from '@/types/auth'

const authStore = useAuthStore()
const router = useRouter()

const errorMessage = ref('')
const fieldErrors = ref<Record<string, string[]>>({})

const registerCredentials = reactive<RegisterCredentials>({
  name: '',
  email: '',
  password: '',
  c_password: '',
})

const handleRegister = async () => {
  const response = await authStore.register(registerCredentials)

  if (response.success) {
    router.push('/tasks')
  } else {
    errorMessage.value = response.message || 'Registration failed.'
    fieldErrors.value = response.errors || {}
  }
}
</script>
