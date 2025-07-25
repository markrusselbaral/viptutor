import { defineStore } from 'pinia'
import { useAuthService } from '@/services/authService'
import type { LoginCredentials, RegisterCredentials } from '@/types/auth'

export const useAuthStore = defineStore('auth', () => {
  const authService = useAuthService()

  async function login(loginCredentials: LoginCredentials) {
    return await authService.loginUser(loginCredentials)
  }

  async function register(registerCredentials: RegisterCredentials) {
    return await authService.registerUser(registerCredentials)
  }

  async function authCheck() {
    return await authService.whoAmI()
  }

 function logout() {
    localStorage.removeItem('token')
  }

  return {
   login,
   register,
   authCheck,
   logout
  }
})