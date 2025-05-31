<script setup lang="ts">
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler';
import type { DatatableProps, Pagination } from '@/types/components/datatable';
import { ref, watch, onMounted, computed } from 'vue'

const props = defineProps<DatatableProps>()

const { showError } = useApiErrorHandler()

const pagination = ref<Pagination>({ offset: 0, limit: 30 })
const items = ref<any[]>([])
const loading = ref(false)
const total = ref(0)

const limits = [10, 30, 50, 100, 150, 200]

const fetchData = async () => {
  loading.value = true
  try {
    const response = await props.fetchApi({
      offset: pagination.value.offset,
      limit: pagination.value.limit,
      filters: props.filters,
    })
    items.value = response.data
    total.value = response.total_filtered
  } catch (e: any) {
    showError(e)
  } finally {
    loading.value = false
  }
}

watch(() => pagination.value.offset, fetchData, { deep: true })
watch(() => [pagination.value.limit, props.filters], () => {
  pagination.value.offset = 0
  fetchData()
}, { deep: true })
watch(
  () => props.refresh,
  () => {
    pagination.value.offset = 0
    fetchData()
  })
onMounted(fetchData)

const pageCount = computed(() => Math.ceil(total.value / pagination.value.limit))
</script>

<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <span>Total: {{ total }}</span>
      <select v-model="pagination.limit" class="form-select w-auto">
        <option v-for="limit in limits" :key="limit" :value="limit">
          {{ limit }} por página
        </option>
      </select>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th v-for="col in props.columns" :key="col.label">{{ col.label }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td v-for="col in props.columns" :key="col.label">
            <slot :name="col.slot" :item="item" v-if="col.slot"></slot>
            <span v-else>{{ item[col.key!] }}</span>
          </td>
        </tr>
        <tr v-if="!items.length && !loading">
          <td :colspan="props.columns.length" class="text-center">Nenhum registro encontrado.</td>
        </tr>
        <tr v-if="loading">
          <td :colspan="props.columns.length" class="text-center">Carregando...</td>
        </tr>
      </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-2">
      <button class="btn btn-sm btn-outline-secondary" :disabled="pagination.offset <= 0" @click="pagination.offset--">
        Anterior
      </button>
      <span>Página {{ pagination.offset + 1 }} de {{ pageCount }}</span>
      <button
        class="btn btn-sm btn-outline-secondary"
        :disabled="pagination.offset + 1 >= pageCount"
        @click="pagination.offset++"
      >
        Próxima
      </button>
    </div>
  </div>
</template>
