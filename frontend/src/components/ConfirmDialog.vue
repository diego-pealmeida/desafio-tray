<template>
  <BaseModal :visible="visible" title="Confirmar Ação" @close="$emit('cancel')">
    <p class="mb-3">{{ message }}</p>
    <div class="d-flex justify-content-end gap-2">
      <BaseButton label="Cancelar" variant="secondary" @click="$emit('cancel')"/>
      <BaseButton label="Confirmar" variant="danger" @click="$emit('confirm')"/>
    </div>
  </BaseModal>
</template>

<script lang="ts" setup>
import BaseButton from './BaseButton.vue';
import BaseModal from './BaseModal.vue';

interface Props {
  visible: boolean;
  message: string;
}
defineProps<Props>();
defineEmits(['confirm', 'cancel']);
</script>
