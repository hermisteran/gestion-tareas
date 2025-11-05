<template>
  <div class="card mb-3 shadow-sm m-2">
    <div class="card-body">
      <form class="row g-3" @submit.prevent="applyFilters">
        <!-- Texto -->
        <div class="col-md-12">
          <label class="form-label">Buscar</label>
          <input
            type="text"
            v-model="filters.search"
            class="form-control"
            placeholder="Título o descripción..."
          />
        </div>

        <!-- Estado -->
        <div class="col-md-3">
          <label class="form-label">Estado</label>
          <select v-model="filters.status" class="form-select">
            <option value="">Todos</option>
            <option v-for="s in store.statuses" :key="s.value" :value="s.value">
              {{ s.label }}
            </option>
          </select>
        </div>

        <!-- Prioridad -->
        <div class="col-md-3">
          <label class="form-label">Prioridad</label>
          <select v-model="filters.priority_id" class="form-select">
            <option value="">Todas</option>
            <option v-for="p in store.priorities" :key="p.id" :value="p.id">
              {{ p.priority }}
            </option>
          </select>
        </div>

        <!-- Fecha desde -->
        <div class="col-md-3">
          <label class="form-label">Desde</label>
          <input type="date" v-model="filters.due_from" class="form-control" />
        </div>

        <!-- Fecha hasta -->
        <div class="col-md-3">
          <label class="form-label">Hasta</label>
          <input type="date" v-model="filters.due_to" class="form-control" />
        </div>

        <!-- Botones -->
        <div class="col-md-12 text-end mt-3">
          <button type="submit" class="btn btn-primary me-2">
            <i class="bi bi-funnel"></i> Aplicar filtros
          </button>
          <button type="button" class="btn btn-outline-secondary" @click="clearFilters">
            Limpiar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { useTasksStore } from "../stores/tasks";

const store = useTasksStore();
const emit = defineEmits(["filter"]);

const filters = reactive({
  search: "",
  status: "",
  priority_id: "",
  due_from: "",
  due_to: "",
});

const applyFilters = () => {
  emit("filter", { ...filters });
};

const clearFilters = () => {
  Object.keys(filters).forEach((k) => (filters[k] = ""));
  emit("filter", { ...filters });
};
</script>
