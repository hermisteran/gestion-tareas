<template>
  <div
    v-if="show"
    class="modal fade show d-block"
    tabindex="-1"
    style="background-color: rgba(0, 0, 0, 0.5)"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-secondary text-white">
          <h5 class="modal-title">
            {{ task && task.id ? "Editar Tarea" : "Nueva Tarea" }}
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div v-if="errorMessage" class="alert alert-danger">
            {{ errorMessage }}
          </div>
          <form @submit.prevent="submitForm">
            <div class="mb-3">
              <label class="form-label">Título <span class="required">*</span></label>
              <input
                v-model="form.title"
                class="form-control"
                required
                :disabled="viewTask"
              />
              <div v-if="errors.title" class="text-danger small">
                {{ errors.title[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label"
                >Descripción <span class="required">*</span></label
              >
              <textarea
                v-model="form.description"
                class="form-control"
                :disabled="viewTask"
              ></textarea>
              <div v-if="errors.description" class="text-danger small">
                {{ errors.description[0] }}
              </div>
            </div>
            <div class="mb-3" v-if="form.status">
              <label class="form-label">Estado</label>
              <select v-model="form.status" class="form-select" :disabled="viewTask">
                <option v-for="s in store.statuses" :key="s.value" :value="s.value">
                  {{ s.label }}
                </option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Fecha límite</label>
              <input
                type="date"
                v-model="form.due_date"
                class="form-control"
                :disabled="viewTask"
              />
              <div v-if="errors.due_date" class="text-danger small">
                {{ errors.due_date[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Prioridad <span class="required">*</span></label>
              <select
                v-model="form.priority_id"
                class="form-select"
                required
                :disabled="viewTask"
              >
                <option value="">Seleccione</option>
                <option v-for="p in priorities" :key="p.id" :value="p.id">
                  {{ p.priority }}
                </option>
              </select>
              <div v-if="errors.priority_id" class="text-danger small">
                {{ errors.priority_id[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Etiquetas <span class="required">*</span></label>
              <div class="form-check" v-for="t in tags" :key="t.id">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :id="'tag-' + t.id"
                  :value="t.id"
                  v-model="form.tags"
                  :disabled="viewTask"
                />
                <label class="form-check-label" :for="'tag-' + t.id">{{ t.tag }}</label>
              </div>
              <div v-if="errors.tags" class="text-danger small">
                {{ errors.tags[0] }}
              </div>
            </div>
            <div class="text-end">
              <button
                type="submit"
                class="btn btn-success"
                v-if="!viewTask"
                :disabled="processing"
              >
                {{ processing ? "Procesando..." : "Guardar" }}
              </button>
              <button
                type="button"
                class="btn btn-warning"
                v-if="viewTask && form && form.status !== 'completada'"
                @click="enableEdit"
              >
                Editar
              </button>
              <button
                type="button"
                class="btn btn-secondary ms-2"
                @click="$emit('cancel')"
              >
                Cancelar
              </button>
              <br />
              <small>(<span class="required">*</span>) datos requeridos.</small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, toRefs } from "vue";
import { useTasksStore } from "../stores/tasks";

const props = defineProps({
  show: Boolean,
  view: Boolean,
  task: Object,
});

const emit = defineEmits(["cancel", "save"]);

const store = useTasksStore();
const errors = ref({});
const errorMessage = ref("");
let processing = ref(false);
const { priorities, tags } = toRefs(store);
const viewTask = ref(props.view);

const form = ref({
  title: "",
  description: "",
  due_date: null,
  priority_id: "",
  tags: [],
});

watch(
  () => props.show,
  (val) => {
    errorMessage.value = "";
    errors.value = "";
    viewTask.value = props.view;
    if (val) {
      form.value = {
        title: props.task.title,
        description: props.task.description,
        status: props.task.status,
        due_date: props.task.due_date || null,
        priority_id: props.task.priority?.id,
        tags: props.task.tags ? props.task.tags.map((t) => t.id) : [],
      };
    } else {
      form.value = {
        title: "",
        description: "",
        due_date: null,
        priority_id: "",
        tags: [],
      };
    }
  }
);

const submitForm = async () => {
  errorMessage.value = "";
  errors.value = "";
  processing.value = true;
  try {
    if (props.task && props.task.id) {
      await store.updateTask(props.task.id, form.value);
    } else {
      await store.createTask(form.value);
    }
    emit("save");
  } catch (err) {
    processing.value = false;
    if (err.response && err.response.status === 422) {
      errorMessage.value = err.response.data.message || "Error de validación";
      errors.value = err.response.data.errors || {};
    } else {
      errorMessage.value = "Ocurrió un error inesperado";
    }
    console.error("Error al guardar tarea:", err);
  }
};

const enableEdit = () => {
  viewTask.value = false;
};
</script>
<style>
.required {
  color: red;
}
</style>
