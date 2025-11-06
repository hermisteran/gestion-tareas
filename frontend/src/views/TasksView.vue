<template>
  <div class="container py-4">
    <h2 class="mb-4">Gestión de Tareas!</h2>
    <button class="btn btn-primary mb-3" @click="openForm">Nueva Tarea</button>

    <div v-if="loading" class="text-center py-4">
      <div class="spinner-border text-primary"></div>
    </div>

    <TaskForm
      :show="showForm"
      @save="onSave"
      @cancel="showForm = false"
      :task="editTask"
      :view="viewTask"
    />

    <TaskFilters @filter="onFilter" />

    <TaskList :tasks="store.tasks" :openForm="openForm" @delete="onDelete" />

    <Pagination :meta="store.meta" @page="onPageChange" />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useTasksStore } from "../stores/tasks";
import TaskList from "@/components/TaskList.vue";
import TaskForm from "@/components/TaskForm.vue";
import TaskFilters from "@/components/TaskFilters.vue";
import Pagination from "@/components/Pagination.vue";
const store = useTasksStore();
const showForm = ref(false);
const viewTask = ref(false);
const editTask = ref(null);
const loading = computed(() => store.loading);
const loadData = async () => {
  await store.fetchOptions();
  await store.fetchTasks();
};

const openForm = (task = null, view = false) => {
  editTask.value = task;
  showForm.value = true;
  viewTask.value = view;
};

const onDelete = async (id) => {
  if (confirm("¿Eliminar esta tarea?")) {
    await store.deleteTask(id);
    alert("Tarea Eliminada.");
  }
};

const onSave = async () => {
  showForm.value = false;
  editTask.value = null;
  await store.fetchTasks();
};

const onFilter = async (filters) => {
  store.filters = filters;
  await store.fetchTasks();
};
const onPageChange = async (page) => {
  await store.fetchTasks({ page });
};
onMounted(loadData);
</script>
