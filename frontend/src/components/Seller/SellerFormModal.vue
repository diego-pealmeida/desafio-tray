  <script setup lang="ts">
  import { ref, watch, computed } from 'vue'
  import BaseModal from '@/components/BaseModal.vue'
  import BaseInput from '@/components/BaseInput.vue'
  import BaseButton from '@/components/BaseButton.vue'
  import { createSeller, updateSeller } from '@/api/sellers'
import { useApiErrorHandler } from '@/hooks/useApiErrorHandler'

  interface Props {
    show: boolean
    seller?: any | null
  }

  const props = defineProps<Props>()
  const emit = defineEmits(['update:show', 'update:seller', 'saved'])

  const { showError } = useApiErrorHandler()

  const isEdit = computed(() => !!props.seller?.id)

  const cleanForm = () => {
    validated.value = false
    form.value = {
      name: '',
      email: ''
    }
  }

  const form = ref({
    name: '',
    email: ''
  })

  const loading = ref<boolean>(false)
  const errors = ref<{ [key: string]: string }>({})
  const validated = ref<boolean>(false)

  watch(
    () => props.seller,
    (newVal) => {
      if (newVal) {
        return form.value = {
          name: newVal.name,
          email: newVal.email
        }
      }

      cleanForm()
    },
    { immediate: true }
  )

  const validateForm = () => {
    errors.value = {}

    if (!form.value.name.trim() || form.value.name.length < 3) {
      errors.value.name = 'O nome é obrigatório e deve conter pelo menos 3 caracteres.'
    }

    if (!form.value.email.trim()) {
      errors.value.email = 'O e-mail é obrigatório.'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
      errors.value.email = 'Informe um e-mail válido.'
    }

    validated.value = true

    return Object.keys(errors.value).length === 0
  }

  const handleSave = async () => {
    if (!validateForm()) return

    loading.value = true

    const payload = {
      name: form.value.name,
      email: form.value.email
    }

    try {
      isEdit.value
      ? await updateSeller(props.seller.id, payload)
      : await createSeller(payload)

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
    emit('update:seller', null);
  }

  watch(() => [form.value.name, form.value.email], () => {
    if (validated.value) validateForm()
  })
  </script>

  <template>
    <BaseModal :visible="show" @close="close" :title="isEdit ? 'Editar Vendedor' : 'Novo Vendedor'">
      <div class="row g-3">
        <div class="col-12">
          <BaseInput label="Nome do Vendedor" v-model="form.name" max="60" :error="errors.name" />
        </div>
        <div class="col-12">
          <BaseInput label="E-mail" type="email" v-model="form.email" max="255" :error="errors.email" />
        </div>
      </div>

      <template #footer>
        <BaseButton label="Cancelar" class="mx-2" variant="secondary" @click="close" :disabled="loading" />
        <BaseButton label="Salvar" variant="primary" @click="handleSave" :loading="loading" />
      </template>
    </BaseModal>
  </template>
