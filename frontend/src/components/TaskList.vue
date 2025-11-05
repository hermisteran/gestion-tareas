<template>
  <div>
    <div class="task-list">
      <div class="task-header m-2 bg-light p-2 rounded fw-bold d-flex">
        <div class="col-6 col-md-6">Tarea</div>

        <div class="col-md-3 text-center d-none d-md-block">Prioridad</div>

        <div class="col-6 col-md-3 text-end">Acciones</div>
      </div>
      <div
        v-for="task in tasks"
        :key="task.id"
        class="card py-3 bg-body-secondary p-2 m-2"
      >
        <div class="row align-items-center">
          <div class="col-12 col-md-6 mb-2 mb-md-0">
            <div class="fw-bold">{{ task.title }}</div>

            <small>
              Estado:
              <span :class="['badge', getStatusBadge(task.status)]">{{
                task.status
              }}</span>
            </small>

            <small v-if="task.due_date" class="d-block mt-1">
              Fecha Límite:
              <span class="badge text-bg-secondary">{{ formatDate(task.due_date) }}</span>
            </small>
          </div>

          <div class="col-6 col-md-3 text-md-center mb-2 mb-md-0">
            <span class="d-md-none fw-bold me-2">Prioridad:</span>
            {{ task.priority?.priority }}
          </div>

          <div class="col-6 col-md-3 text-end">
            <button class="btn btn-sm btn-dark d-inline" @click="openForm(task, true)">
              <i class="bi bi-eye-fill"></i>
            </button>

            <div v-if="task.status !== 'completada'" class="d-inline">
              <button class="btn btn-sm btn-warning ms-1 ms-md-2" @click="openForm(task)">
                <i class="bi bi-pencil"></i> Editar
              </button>
              <button
                class="btn btn-sm btn-danger ms-1 ms-md-2"
                @click="$emit('delete', task.id)"
              >
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="!tasks || tasks.length === 0"
        class="card py-3 bg-body-secondary p-2 m-2"
      >
        No hay tareas
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  tasks: Array,
  openForm: Function,
});

const getStatusBadge = (status) => {
  switch (status) {
    case "pendiente":
      return "text-bg-danger";
    case "en_progreso":
      return "text-bg-warning";
    case "completada":
      return "text-bg-success";
    default:
      return "text-bg-info";
  }
};

const formatDate = (date) => {
  if (!date) return "";
  const [year, month, day] = date.split("-");
  return `${day}/${month}/${year}`;
};
</script>

<style scoped>
.task-item:last-child {
  border-bottom: none !important;
}
.task-header {
  border-top: 1px solid #dee2e6;
}
</style>
