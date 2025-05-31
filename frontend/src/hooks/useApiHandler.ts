import type { AxiosResponse } from 'axios'
import type { ErrorResponse } from '@/types/api'

export async function apiHandler<T = any>(
  request: () => Promise<AxiosResponse<T>>
): Promise<T> {
  try {
    const response = await request()
    return response.data
  } catch (error: any) {
    if (error.response?.data?.errors) {
      const errData: ErrorResponse = error.response.data
      throw errData
    }

    if (error.response?.data?.message) {
      throw { errors: [error.response.data.message] }
    }

    throw { errors: ['Erro desconhecido. Tente novamente mais tarde.'] }
  }
}
