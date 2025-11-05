import api from './axios'

export default {
  list(params) {
    return api.get('/tasks', { params })
  },
  create(payload) {
    return api.post('/tasks', payload)
  },
  update(id, payload) {
    return api.put(`/tasks/${id}`, payload)
  },
  delete(id) {
    return api.delete(`/tasks/${id}`)
  },
  priorities() {
    return api.get('/priorities')
  },
  tags() {
    return api.get('/tags')
  },
  statuses() {
    return api.get('/statuses');
  }
}
