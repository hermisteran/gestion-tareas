<template>
  <nav v-if="meta && meta.last_page > 1" aria-label="Page navigation" class="mt-3">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <button class="page-link" @click="$emit('page', meta.current_page - 1)">
          Anterior
        </button>
      </li>
      <li
        v-for="page in pages"
        :key="page"
        class="page-item"
        :class="{ active: meta.current_page === page }"
      >
        <button class="page-link" @click="$emit('page', page)">{{ page }}</button>
      </li>
      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <button class="page-link" @click="$emit('page', meta.current_page + 1)">
          Siguiente
        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({ meta: Object });
const pages = computed(() => {
  if (!props.meta) return [];
  const total = props.meta.last_page;
  const current = props.meta.current_page;
  const start = Math.max(1, current - 2);
  const end = Math.min(total, current + 2);
  return Array.from({ length: end - start + 1 }, (_, i) => start + i);
});
</script>
