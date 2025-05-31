<template>
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%; border-radius: 1rem;">
      <h3 class="text-center mb-4">Login</h3>

      <form @submit.prevent="handleLogin" novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input
            type="email"
            id="email"
            class="form-control"
            v-model="email"
            required
            :class="{ 'is-invalid': submitted && !isValidEmail(email) }"
          />
          <div class="invalid-feedback">Informe um e-mail válido.</div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input
            type="password"
            id="password"
            class="form-control"
            v-model="password"
            required
            :class="{ 'is-invalid': submitted && password.length === 0 }"
          />
          <div class="invalid-feedback">Informe sua senha.</div>
        </div>

        <div class="form-check mb-3">
          <input
            class="form-check-input"
            type="checkbox"
            id="rememberMe"
            v-model="rememberMe"
          />
          <label class="form-check-label" for="rememberMe">
            Me mantenha conectado
          </label>
        </div>

        <div v-if="errorMessage" class="alert alert-danger py-2">
          {{ errorMessage }}
        </div>

        <button
          type="submit"
          class="btn btn-primary w-100"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { login } from '@/api/auth'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'

const router = useRouter()
const { showError } = useApiErrorHandler()

const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const loading = ref(false)
const errorMessage = ref('')
const submitted = ref(false)

const isValidEmail = (value: string) => {
  return /.+@.+\..+/.test(value)
}

const handleLogin = async () => {
  submitted.value = true
  errorMessage.value = ''

  if (!isValidEmail(email.value) || password.value.length === 0) return

  loading.value = true

  login({
    email: email.value,
    password: password.value,
    remember_me: rememberMe.value,
  })
  .then((response) => {
    localStorage.setItem('token', response.access_token)
    localStorage.setItem('token_expires_at', (response.expires_at || ''))

    router.push('/orders')
  })
  .catch((e) => {
    showError(e)
  })
  .finally(() => loading.value = false)
}
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
}

input.form-control {
  min-height: 45px;
}

button.btn {
  height: 45px;
  font-weight: 500;
}
</style>
