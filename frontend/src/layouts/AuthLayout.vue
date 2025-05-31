<template>
  <PageLoader v-if="loading" />

  <div v-else class="d-flex layout-wrapper">
    <SideBar />

    <main class="content-area p-4">
      <RouterView />
    </main>
  </div>
</template>

<script setup lang="ts">
import { getMe } from '@/api/users';
import PageLoader from '@/components/PageLoader.vue';
import SideBar from '@/components/SideBar.vue';
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler';
import { onMounted, ref } from 'vue';

const { showError } = useApiErrorHandler()

const loading = ref(false)

const fetchUserData = async () => {
  loading.value = true

  try {
    const response = await getMe()

    localStorage.setItem('user', JSON.stringify(response))
  } catch (e: any) {
    showError(e)
  } finally {
    loading.value = false
  }
}

onMounted(fetchUserData)
</script>

<style scoped>
.layout-wrapper {
  height: 100vh;
  overflow: hidden;
}

.content-area {
  flex: 1;
  height: 100vh;
  overflow-y: auto;
  background-color: #f8f9fa;
}
</style>
