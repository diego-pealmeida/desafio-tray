<template>
  <div>
    <label v-if="label">{{ label }}</label>
    <v-autocomplete
      v-model="internalValue"
      :items="items"
      :loading="loading"
      :item-title="itemTitle"
      :item-value="itemValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :multiple="multiple"
      hide-details
      density="comfortable"
      variant="outlined"
      clearable
      class="bg-white"
      return-object
      :error="!!error"
      :error-messages="error"
      @update:modelValue="$emit('update:modelValue', internalValue)"
      @input="onSearch"
    />
  </div>
</template>

<script lang="ts" setup>
import { ref, watch, onMounted } from 'vue';

interface Props {
  modelValue: any;
  fetchItems: (search: string) => Promise<any[]>;
  itemTitle?: string|((item: any) => string);
  itemValue?: string;
  label?: string;
  placeholder?: string;
  disabled?: boolean;
  multiple?: boolean;
  error?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const internalValue = ref(props.modelValue);
const items = ref<any[]>([]);
const loading = ref(false);

const onSearch = async (search: string) => {
  loading.value = true;
  try {
    items.value = await props.fetchItems(search);
  } finally {
    loading.value = false;
  }
};

watch(() => props.modelValue, (newVal) => {
  internalValue.value = newVal;
});

onMounted(() => onSearch(''));
</script>
