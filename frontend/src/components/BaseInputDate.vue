<template>
  <div>
    <label v-if="label">{{ label }}</label>
    <input
      type="date"
      :value="internalValue"
      :max="max"
      :min="min"
      @input="onInput"
      :class="{'form-control': true, 'is-invalid': !!error}"
    />
    <div class="invalid-feedback">{{ error }}</div>
  </div>
</template>

<script lang="ts" setup>
import { ref, watch, computed } from 'vue';
import { format, parse } from 'date-fns';

interface Props {
  modelValue: string;
  label?: string;
  max?: string;
  min?: string;
  error?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const internalValue = ref('');

watch(() => props.modelValue, (newVal) => {
  internalValue.value = newVal ? format(parse(newVal, 'yyyy-MM-dd', new Date()), 'yyyy-MM-dd') : '';
}, { immediate: true });

const onInput = (e: Event) => {
  const value = (e.target as HTMLInputElement).value;
  emit('update:modelValue', value);
};
</script>
