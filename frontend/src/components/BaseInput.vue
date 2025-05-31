<template>
  <div>
    <label v-if="label">{{ label }}</label>
    <input
      v-bind="$attrs"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :max="max"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      :class="{'form-control': true, 'is-invalid': !!error}"
    />
    <div class="invalid-feedback">{{ error }}</div>
  </div>
</template>

<script lang="ts" setup>
interface Props {
  modelValue: string | number;
  label?: string;
  placeholder?: string;
  type?: string;
  max?: string|number;
  error?: string;
}
defineProps<Props>();
defineEmits(['update:modelValue']);
</script>
