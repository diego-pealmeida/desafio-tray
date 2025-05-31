<template>
  <div v-if="visible" class="modal-backdrop">
    <div class="modal-container">
      <div class="modal-header">
        <h3>{{ title }}</h3>
        <button class="btn" :disabled="disabledClose" @click="close"><i class="bi bi-x-lg"></i></button>
      </div>

      <div class="modal-body">
        <slot></slot>
      </div>

      <div class="modal-footer">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
interface Props {
  title: string;
  visible: boolean;
  disabledClose?: boolean;
}
withDefaults(defineProps<Props>(), {
  title: '',
  visible: false,
  disabledClose: false
});
const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-container {
  background: white;
  border-radius: 8px;
  width: 600px;
  max-width: 100%;
  padding: 1rem;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.modal-body {
  margin-top: 1rem;
}
.modal-footer {
  margin-top: 1.5rem;
  text-align: right;
}
</style>
