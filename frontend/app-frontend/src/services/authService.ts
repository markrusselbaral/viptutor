import { login, user, register } from '@/api/auth'
import type { LoginCredentials, RegisterCredentials } from '@/types/auth'
import { errorMessages } from 'vue/compiler-sfc'
import { ref } from 'vue'

export function useAuthService() {

  async function loginUser(loginCredentials: LoginCredentials) {
    try {
      const response = await login(loginCredentials)
      const token = response.token

      localStorage.setItem('token', token)

      return {
        success: true,
        message: 'Login successful',
      }
    } catch (error: any) {
      return {
        success: false,
        message: error.response?.data?.message || 'Login failed',
      }
    }
  }

  async function registerUser(RegisterCredentials : RegisterCredentials) {
    try {
      const response = await register(RegisterCredentials)
      const token = response.token

      localStorage.setItem('token', token)

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

  async function whoAmI() {
    return await user()
  }



  return {
    loginUser,
    registerUser,
    whoAmI
  }
}
