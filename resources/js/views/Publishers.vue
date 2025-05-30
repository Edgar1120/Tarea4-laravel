<template>
  <div class="container mt-4">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></link>
    <div v-if="view === 'index'">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editoriales</h2>
        <button @click="switchToCreate" class="btn btn-success">➕ Agregar Editorial</button>
      </div>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>País</th>
              <th>Fundación</th>
              <th>Género</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="publisher in publishers" :key="publisher.id">
              <td>{{ publisher.id }}</td>
              <td>{{ publisher.name }}</td>
              <td>{{ publisher.country }}</td>
              <td>{{ publisher.founded }}</td>
              <td>{{ publisher.genere }}</td>
              <td>
                <div class="d-flex gap-1">
                 <button class="btn btn-outline-info btn-sm" @click="showPublisher(publisher.id)" title="Ver">
                    <i class="bi bi-eye"></i>
                  </button>
                  <button class="btn btn-outline-warning btn-sm" @click="editPublisher(publisher)" title="Editar">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm" @click="deletePublisher(publisher.id)" title="Eliminar">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </td>

            </tr>
            <tr v-if="publishers.length === 0">
              <td colspan="6" class="text-center">No hay editoriales registradas.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-else-if="view === 'show'">
      <h2>Detalles de la Editorial</h2>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ currentPublisher.name }}</h4>
          <p><strong>País:</strong> {{ currentPublisher.country }}</p>
          <p><strong>Fundación:</strong> {{ currentPublisher.founded }}</p>
          <p><strong>Género:</strong> {{ currentPublisher.genere }}</p>
        </div>
      </div>
      <button class="btn btn-secondary mt-3" @click="view = 'index'">← Volver a la lista</button>
    </div>

    <div v-else-if="view === 'edit' || view === 'create'">
      <h2 class="text-center">{{ view === 'edit' ? 'Editar Editorial' : 'Agregar Editorial' }}</h2>

      <div v-if="formErrors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in formErrors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input v-model="form.name" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">País</label>
          <input v-model="form.country" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Año de Fundación</label>
          <input v-model="form.founded" type="number" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Género</label>
          <input v-model="form.genere" type="text" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary ms-2" @click="view = 'index'">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const publishers = ref([])
const currentPublisher = ref({})
const view = ref('index')

const form = ref({
  name: '',
  country: '',
  founded: '',
  genere: ''
})

const formErrors = ref([])
const successMessage = ref('')

const fetchPublishers = async () => {
  const res = await axios.get('/api/publishers')
  publishers.value = res.data
}

const showPublisher = async (id) => {
  const res = await axios.get(`/api/publishers/${id}`)
  currentPublisher.value = res.data
  view.value = 'show'
}

const editPublisher = (publisher) => {
  form.value = { ...publisher }
  formErrors.value = []
  view.value = 'edit'
}

const switchToCreate = () => {
  form.value = {
    name: '',
    country: '',
    founded: '',
    genere: ''
  }
  formErrors.value = []
  view.value = 'create'
}

const submitForm = async () => {
  try {
    if (view.value === 'create') {
      await axios.post('/api/publishers', form.value)
      successMessage.value = 'Editorial creada exitosamente.'
    } else {
      await axios.put(`/api/publishers/${form.value.id}`, form.value)
      successMessage.value = 'Editorial actualizada exitosamente.'
    }
    await fetchPublishers()
    view.value = 'index'
    formErrors.value = []
  } catch (error) {
    if (error.response?.data?.errors) {
      formErrors.value = Object.values(error.response.data.errors).flat()
    }
  }
}

const deletePublisher = async (id) => {
  if (confirm('¿Estás seguro de eliminar esta editorial?')) {
    await axios.delete(`/api/publishers/${id}`)
    successMessage.value = 'Editorial eliminada.'
    await fetchPublishers()
  }
}

onMounted(fetchPublishers)
</script>

<style scoped>
.form-label {
  font-weight: bold;
}
.form-control {
  border-radius: 10px;
  padding: 10px;
}
.btn {
  margin-right: 0.5rem;
}
</style>
