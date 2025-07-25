import axiosInstance from './index'
import type { LoginCredentials, RegisterCredentials } from '@/types/auth'

export async function login(loginCredentials: LoginCredentials) 
{
  const { data } = await axiosInstance.post('/login', loginCredentials)
  return data
}

export async function register(RegisterCredentials: RegisterCredentials) 
{
  const { data } = await axiosInstance.post('/register', RegisterCredentials)
  return data
}

export async function user() 
{
  const { data } = await axiosInstance.get('/user')
  return data
}

