<template>
  <button
    v-bind="$attrs"
    :type="type"
    :class="['btn', sizeClass, outline ? variantOutlineClass : variantClass]"
    :disabled="disabled || loading"
    @click="$emit('click', $event)"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <i v-else-if="icon" :class="icon"></i>
    <span v-if="label" :class="{ 'ms-2': loading }">{{ label }}</span>
  </button>
</template>

<script lang="ts" setup>
interface Props {
  label?: string;
  type?: 'button' | 'submit' | 'reset';
  variant?: 'primary' | 'secondary' | 'danger' | 'success' | 'warning' | 'info';
  icon?: string;
  size?: 'sm' | 'md' | 'lg';
  outline?: boolean;
  loading?: boolean;
  disabled?: boolean;
}
const props = withDefaults(defineProps<Props>(), {
  label: '',
  type: 'button',
  variant: 'primary',
  icon: '',
  size: 'md',
  outline: false,
  loading: false,
  disabled: false
});

defineEmits(['click']);

const sizeClass = {
  sm: 'btn-sm',
  md: 'btn-md',
  lg: 'btn-lg'
}[props.size];

const variantClass = {
  primary: 'btn-primary',
  secondary: 'btn-secondary',
  danger: 'btn-danger',
  success: 'btn-success',
  warning: 'btn-warning',
  info: 'btn-info',
}[props.variant];

const variantOutlineClass = {
  primary: 'btn-outline-primary',
  secondary: 'btn-outline-secondary',
  danger: 'btn-outline-danger',
  success: 'btn-outline-success',
  warning: 'btn-outline-warning',
  info: 'btn-outline-info',
}[props.variant];
</script>
