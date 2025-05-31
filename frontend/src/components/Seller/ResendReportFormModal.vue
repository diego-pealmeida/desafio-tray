<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import BaseModal from '@/components/BaseModal.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseInputDate from '../BaseInputDate.vue'
import { format, subDays } from 'date-fns'
import { resendDailyOrderReport } from '@/api/sellers'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'

interface Props {
  show: boolean;
  seller?: any | null;
}

const props = defineProps<Props>()
const emit = defineEmits(['update:show', 'update:seller', 'processed'])

const { showError } = useApiErrorHandler()

const yesterday = computed(() => format(subDays(new Date(), 1), 'yyyy-MM-dd'));

const cleanForm = () => {
  validated.value = false
  form.value = {
    date: ''
  }
}

const form = ref({
  date: ''
})

const loading = ref<boolean>(false)
const errors = ref<{ [key: string]: string }>({})
const validated = ref<boolean>(false)

const validateForm = () => {
  errors.value = {}

  if (!form.value.date) {
    errors.value.date = 'A data do relatório é obrigatória.'
  }

  validated.value = true

  return Object.keys(errors.value).length === 0
}

const handleSendReport = async () => {
  if (!props.seller || !validateForm()) return

  loading.value = true

  try {
    await resendDailyOrderReport(props.seller.id, {
      date: form.value.date
    })

    emit('processed')
    close()
  } catch (e: any) {
    showError(e)
  } finally {
    loading.value = false
  }
}

const close = () => {
  cleanForm()
  emit('update:show', false);
  emit('update:seller', null);
}

watch(() => form.value.date, () => {
    if (validated.value) validateForm()
  })
</script>

<template>
  <BaseModal :visible="show" @close="close" :disabled-close="loading" title="Reenvio de Relatório">
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <BaseInputDate label="Data do relatório" v-model="form.date" :max="yesterday" :error="errors.date" />
      </div>
    </div>

    <template #footer>
      <BaseButton label="Cancelar" class="mx-2" variant="secondary" @click="close" :disabled="loading" />
      <BaseButton label="Enviar" variant="primary" @click="handleSendReport" :loading="loading"/>
    </template>
  </BaseModal>
</template>
