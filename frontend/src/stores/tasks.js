import { defineStore } from 'pinia'
import tasksApi from '../services/tasks'

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    meta: {},
    priorities: [],
    tags: [],
    filters: { search: '', status: '', priority_id: '' },
    loading: false,
    statuses: [],
  }),
  actions: {
    async fetchTasks(params = {}) {
      this.loading = true
      const { data } = await tasksApi.list({ ...this.filters, ...params })
      this.tasks = data.data
      this.meta = data.meta
      this.loading = false
    },
    async fetchOptions() {
      const [priorities, tags, statuses] = await Promise.all([
        tasksApi.priorities(),
        tasksApi.tags(),
        tasksApi.statuses()
      ]);
      this.priorities = priorities.data.data || priorities.data;
      this.tags = tags.data.data || tags.data;
      this.statuses = statuses.data;
    },
    async createTask(payload) {
      const { data } = await tasksApi.create(payload)
      this.tasks.push(data.data)
    },
    async updateTask(id, payload) {      
      const { data } = await tasksApi.update(id, payload)
      const index = this.tasks.findIndex((t) => t.id === id)
      if (index !== -1) this.tasks[index] = data.data
    },
    async deleteTask(id) {
      await tasksApi.delete(id)
      this.tasks = this.tasks.filter((t) => t.id !== id)
    },
  },
})
