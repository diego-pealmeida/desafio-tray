<script setup lang="ts">
import { ref } from 'vue'
import { deleteOrder, getOrders } from '@/api/orders.ts'
import BaseDatatable from '@/components/BaseDatatable.vue'
import BaseAutocomplete from '@/components/BaseAutocomplete.vue'
import BaseInputDate from '@/components/BaseInputDate.vue'
import OrderFormModal from '@/components/Order/OrderFormModal.vue'
import ConfirmDialog from '@/components/ConfirmDialog.vue'
import { getSellers } from '@/api/sellers.ts'
import type { OrderResponse } from '@/types/api/order'
import type { ConfirmDeleteProps } from '@/types/pages/order'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'

const { showError } = useApiErrorHandler()

const filters = ref({
  seller: null,
  dateStart: '',
  dateEnd: '',
})

const columns = [
  { label: 'Vendedor', key: 'seller_name' },
  { label: 'Data', key: 'date_formated' },
  { label: 'Valor', key: 'value_formated' },
  { label: 'Comissão', key: 'commission' },
  { label: 'Ações', slot: 'actions' },
]

const refresh = ref<boolean>(false)
const showForm = ref<boolean>(false)
const editingOrder = ref<OrderResponse | null>(null)
const confirmDelete = ref<ConfirmDeleteProps>({ show: false, order: null })

const refreshData = () => {
  refresh.value = !refresh.value
}

const fetchOrders = async ({ offset, limit, filters }: any) => {
  try {
    const response = await getOrders({
    offset,
    limit,
    seller_id: filters.seller?.id ?? undefined,
    date_start: filters.dateStart ?? undefined,
    date_end: filters.dateEnd ?? undefined,
  })

    return response
  } catch (e: any) {
    showError(e)
  }

  return {
    data: [],
    total: 0,
    total_filtered: 0
  }
}

const fetchSellers = async (search: string) => {
  const { data } = await getSellers({ filter: search, limit: 100 });
  return data;
};

const closeConfirmDelete = () => {
  confirmDelete.value = { show: false, order: null }
}

const closeModal = () => {
  showForm.value = false
  editingOrder.value = null
}

const saved = () => {
  closeModal()
  refreshData()
}

const removeOrder = async () => {
  if (!confirmDelete.value.order) return

  try {
    await deleteOrder(confirmDelete.value.order.id)
    closeConfirmDelete()
    refreshData()
  } catch (e: any) {
    showError(e)
  }
}

const handleEdit = (order: any) => {
  editingOrder.value = order
  showForm.value = true
}
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="row g-3">
          <div class="col-12">
            <BaseAutocomplete
              label="Vendedor"
              v-model="filters.seller"
              :fetch-items="fetchSellers"
              :item-title="(item: any) => `${item.name} (${item.email})`"
            />
          </div>
          <div class="col-6">
            <BaseInputDate label="Data de" v-model="filters.dateStart" />
          </div>
          <div class="col-6">
            <BaseInputDate label="Data até" v-model="filters.dateEnd" :min="filters.dateStart" />
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button class="btn btn-primary mb-2" @click="showForm = true">Nova Venda</button>
    </div>

    <BaseDatatable :columns="columns" :fetchApi="fetchOrders" :refresh="refresh" :filters="filters">
      <template #actions="{ item }">
        <button title="Editar" class="btn btn-sm btn-warning me-1" @click="handleEdit(item)">
          <i class="bi bi-pencil-square"></i>
        </button>
        <button title="Remover" class="btn btn-sm btn-danger" @click="confirmDelete = { show: true, order: item }">
          <i class="bi bi-trash3-fill"></i>
        </button>
      </template>
    </BaseDatatable>

    <OrderFormModal v-model:show="showForm" v-model:order="editingOrder" @saved="saved" />

    <ConfirmDialog
      :visible="confirmDelete.show"
      :message="`Deseja realmente excluir o pedido de ${confirmDelete.order?.seller_name} em ${confirmDelete.order?.date_formated} e valor ${confirmDelete.order?.value_formated}?`"
      @confirm="removeOrder"
      @cancel="closeConfirmDelete"
    />
  </div>
</template>
