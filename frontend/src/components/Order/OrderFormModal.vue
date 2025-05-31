<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import BaseModal from '@/components/BaseModal.vue'
import BaseAutocomplete from '@/components/BaseAutocomplete.vue'
import BaseInput from '@/components/BaseInput.vue'
import BaseInputDate from '@/components/BaseInputDate.vue'
import BaseButton from '@/components/BaseButton.vue'
import { createOrder, updateOrder } from '@/api/orders'
import { format } from 'date-fns'
import { getSellers } from '@/api/sellers.ts'
import type { FormModalForm, FormModalProps } from '@/types/pages/order'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'

const props = defineProps<FormModalProps>()
const emit = defineEmits(['update:show', 'update:order', 'saved'])

const { showError } = useApiErrorHandler();

const isEdit = computed(() => !!props.order?.id)

const form = ref<FormModalForm>({
  seller: null,
  date: '',
  value: '',
})

const loading = ref<boolean>(false)
const errors = ref<{ [key: string]: string }>({})
const validated = ref<boolean>(false)

const fetchSellers = async (search: string) => {
  const { data } = await getSellers({ filter: search, limit: 100 });
  return data;
};

const today = computed(() => format(new Date(), 'yyyy-MM-dd'));

const cleanForm = () => {
  validated.value = false
  form.value = {
    seller: null,
    date: '',
    value: ''
  }
}

watch(
  () => props.order,
  (newVal) => {
    if (newVal) {
      return form.value = {
        seller: newVal.seller,
        date: newVal.date.split('/').reverse().join('-'),
        value: newVal.value
      }
    }

    cleanForm()
  },
  { immediate: true }
)

const validateForm = () => {
  errors.value = {}

  if (!form.value.seller) {
    errors.value.seller = 'Selecione um vendedor.'
  }

  if (!form.value.date) {
    errors.value.date = 'Informe uma data.'
  }

  const value = parseFloat(form.value.value as any)
  if (!form.value.value || isNaN(value) || value <= 0 || value > 99999999.99) {
    errors.value.value = 'Informe um decimal válido 8x2.'
  }

  validated.value = true

  return Object.keys(errors.value).length === 0
}

const handleSave = async () => {
  if (!validateForm()) return

  loading.value = true

  const payload = {
    seller_id: form.value.seller?.id,
    date: form.value.date,
    value: typeof form.value.value === 'string' ? parseFloat(form.value.value) : form.value.value
  }

  try {
    isEdit.value
    ? await updateOrder(props.order?.id || 0, payload)
    : await createOrder(payload)

    cleanForm()

    emit('saved')
    emit('update:show', false)
  } catch (e: any) {
    showError(e)
  } finally {
    loading.value = false
  }
}

const close = () => {
  cleanForm()
  emit('update:show', false);
  emit('update:order', null);
}

watch(() => [form.value.seller, form.value.date, form.value.value], () => {
  if (validated.value) validateForm()
})
</script>

<template>
  <BaseModal :visible="show" @close="close" :title="isEdit ? 'Editar Venda' : 'Nova Vendas'">
    <div class="row g-3">
      <div class="col-12">
        <BaseAutocomplete
          label="Vendedor"
          v-model="form.seller"
          :fetchItems="fetchSellers"
          :item-title="(item: any) => `${item.name} (${item.email})`"
          :error="errors.seller"
        />
      </div>
      <div class="col-md-6">
        <BaseInputDate label="Data" v-model="form.date" :max="today" :error="errors.date" />
      </div>
      <div class="col-md-6">
        <BaseInput label="Valor" type="number" v-model="form.value" :error="errors.value" />
      </div>
    </div>

    <template #footer>
      <BaseButton label="Cancelar" class="mx-2" variant="secondary" @click="close" :disabled="loading" />
      <BaseButton label="Salvar" variant="primary" @click="handleSave" :loading="loading" />
    </template>
  </BaseModal>
</template>
