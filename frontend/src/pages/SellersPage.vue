<script setup lang="ts">
import { ref } from 'vue'
import { deleteSeller, getSellers } from '@/api/sellers.ts'
import BaseDatatable from '@/components/BaseDatatable.vue'
import ConfirmDialog from '@/components/ConfirmDialog.vue'
import SellerFormModal from '@/components/Seller/SellerFormModal.vue'
import ResendReportFormModal from '@/components/Seller/ResendReportFormModal.vue'
import BaseButton from '@/components/BaseButton.vue'
import type { ConfirmDeleteProps, ResendDailyReportProps } from '@/types/pages/seller'
import type { SellerResponse } from '@/types/api/seller'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'
import BaseInput from '@/components/BaseInput.vue'

const { showError } = useApiErrorHandler()

const filters = ref({
  filter: ''
})

const columns = [
  { label: 'Nome', key: 'name' },
  { label: 'E-mail', key: 'email' },
  { label: 'Ações', slot: 'actions' },
]

const refresh = ref<boolean>(false)
const showForm = ref<boolean>(false)
const resendDailyReport = ref<ResendDailyReportProps>({ show: false, seller: null })
const editingSeller = ref<SellerResponse | null>(null)
const confirmDelete = ref<ConfirmDeleteProps>({ show: false, seller: null })

const refreshData = () => {
  refresh.value = !refresh.value
}

const fetchSellers = async ({ offset, limit, filters }: any) => {
  try {
    const response = await getSellers({ offset, limit, filter: filters.filter })

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

const closeConfirmDelete = () => {
  confirmDelete.value = { show: false, seller: null }
}

const closeModal = () => {
  showForm.value = false
  editingSeller.value = null
}

const saved = () => {
  closeModal()
  refreshData()
}

const removeSeller = async () => {
  if (!confirmDelete.value.seller) return;

  try {
    await deleteSeller(confirmDelete.value.seller.id)
    closeConfirmDelete()
    refreshData()
  } catch (e:any) {
    showError(e)
  }
}

const handleEdit = (seller: SellerResponse) => {
  editingSeller.value = seller
  showForm.value = true
}

</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="row g-3">
          <div class="col-12">
            <BaseInput label="Pesquisar" v-model="filters.filter" />
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button class="btn btn-primary mb-2" @click="showForm = true">Novo</button>
    </div>

    <BaseDatatable :columns="columns" :fetchApi="fetchSellers" :refresh="refresh" :filters="filters">
      <template #actions="{ item }">
        <BaseButton
          icon="bi bi-send-fill"
          title="Reenviar Relatório" type="button" variant="info" size="sm" class="me-1" @click="resendDailyReport = { show: true, seller: item }" />
        <BaseButton
          icon="bi bi-pencil-square"
          title="Editar" type="button" variant="warning" size="sm" class="me-1" @click="handleEdit(item)" />
        <BaseButton
          icon="bi bi-trash3-fill"
          title="Remover" type="button" variant="danger" size="sm" @click="confirmDelete = { show: true, seller: item }" />
      </template>
    </BaseDatatable>

    <SellerFormModal v-model:show="showForm" v-model:seller="editingSeller" @saved="saved" />

    <ResendReportFormModal v-model:show="resendDailyReport.show" v-model:seller="resendDailyReport.seller" />

    <ConfirmDialog
      :visible="confirmDelete.show"
      :message="`Deseja realmente excluir o vendedor ${confirmDelete.seller?.name} - ${confirmDelete.seller?.email}?`"
      @confirm="removeSeller"
      @cancel="closeConfirmDelete"
    />
  </div>
</template>
