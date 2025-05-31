import Swal from 'sweetalert2'
import '@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css'
import type { ErrorResponse } from '@/types/api'

export function useApiErrorHandler() {
  const showError = (error: ErrorResponse, fallbackMessage = 'Ocorreu um erro inesperado. Tente novamente mais tarde.') => {
    let messages: string[] = error.errors

    if (messages.length === 0) {
      messages = [fallbackMessage]
    }

    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      html: `
        <ul class="text-start mb-0">
          ${messages.map(msg => `<li>${msg}</li>`).join('')}
        </ul>
      `,
      customClass: {
        confirmButton: 'btn btn-danger',
        popup: 'swal2-border-radius'
      },
      buttonsStyling: false
    })

    console.log(messages)
  }

  return { showError }
}
