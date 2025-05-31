<template>
  <aside class="sidebar d-flex flex-column bg-dark text-white p-3">
    <h4 class="mb-4">Gestão de Vendas</h4>

    <ul class="nav nav-pills flex-column mb-auto overflow-auto gap-1">
      <li v-for="item in menuItems" :key="item.path" class="nav-item">
        <RouterLink
          v-if="item.type === 'link'"
          :to="item?.path || ''"
          class="nav-link d-flex align-items-center text-white"
          :class="{ active: isActive(item?.path || '') }"
        >
          <i :class="item.icon + ' me-2'"></i>
          {{ item.label }}
        </RouterLink>
        <button
          v-else
          class="nav-link d-flex align-items-center text-white w-100"
          :disabled="loading"
          @click="item.onclick"
        >
          <i :class="item.icon + ' me-2'"></i>
          {{ item.label }}
        </button>
      </li>
    </ul>

    <div class="mt-auto pt-3 border-top" v-if="user">
      <div class="d-flex align-items-center">
        <i class="bi bi-person-circle fs-4 me-2"></i>
        <div>
          <div class="fw-bold">{{ user.name }}</div>
          <small class="text-white">{{ user.email }}</small>
        </div>
      </div>
    </div>
  </aside>

  <ConfirmDialog
    :visible="showLogoutModal"
    message="Deseja mesmo sair do sistema?"
    @confirm="handleLogout"
    @cancel="showLogoutModal = false"
  />
</template>

<script setup lang="ts">
import { logout } from '@/api/auth';
import router from '@/router';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import ConfirmDialog from './ConfirmDialog.vue';
import type { UserResponse } from '@/types/api/user';
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler';

const route = useRoute();
const loading = ref(false)
const showLogoutModal = ref(false)

const { showError } = useApiErrorHandler()

const user = ref<UserResponse|null>(null);

const handleLogout = async () => {
  loading.value = true
  showLogoutModal.value = false

  try {
    await logout()

    router.push('/login')
  } catch (e: any) {
    showError(e)
  } finally {
    loading.value = false
  }
}

const menuItems = [
  { label: 'Vendas', type: 'link', path: '/orders', icon: 'bi bi-cash-stack' },
  { label: 'Vendedores', type: 'link', path: '/sellers', icon: 'bi bi-people' },
  { label: 'Logout', type: 'button', onclick: () => showLogoutModal.value = true, icon: 'bi bi-box-arrow-right' },
];

const setUser = () => {
  const userString = localStorage.getItem('user')

  if (userString)
    user.value = JSON.parse(userString)
}

const isActive = (path: string) => route.path.startsWith(path);

onMounted(setUser)
</script>

<style scoped>
.sidebar {
  width: 240px;
  height: 100vh;
  overflow-y: auto;
  position: sticky;
  top: 0;
}

.sidebar .nav-link {
  transition: background-color 0.2s;
  border-radius: 0.375rem;
}
.sidebar .nav-link.active,
.sidebar .nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
</style>
