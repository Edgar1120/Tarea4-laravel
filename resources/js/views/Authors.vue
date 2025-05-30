<template>
  
    <div class="container mt-4">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></link>
        <div v-if="view === 'index'">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Autores</h2>
                <button @click="switchToCreate" class="btn btn-success">➕ Agregar Autor</button>
            </div>
            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Nacionalidad</th>
                            <th>Año de nacimiento</th>
                            <th>Especialidades</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="author in authors" :key="author.id">
                            <td>{{ author.id }}</td>
                            <td>{{ author.name }}</td>
                            <td>{{ author.nationality }}</td>
                            <td>{{ author.birth_year }}</td>
                            <td>{{ author.fields }}</td>
                           <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-outline-info btn-sm" @click="showAuthor(author.id)" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" @click="editAuthor(author)" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" @click="deleteAuthor(author.id)" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>


                        </tr>
                        <tr v-if="authors.length === 0">
                            <td colspan="6" class="text-center">No hay autores registrados.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-else-if="view === 'show'">
            <h2>Detalles del Autor</h2>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ currentAuthor.name }}</h4>
                    <p><strong>Nacionalidad:</strong> {{ currentAuthor.nationality }}</p>
                    <p><strong>Año de nacimiento:</strong> {{ currentAuthor.birth_year }}</p>
                    <p><strong>Especialidades:</strong> {{ currentAuthor.fields }}</p>
                </div>
            </div>
            <button class="btn btn-secondary mt-3" @click="view = 'index'">← Volver a la lista</button>
        </div>

        <div v-else-if="view === 'edit' || view === 'create'">
            <h2 class="text-center">{{ view === 'edit' ? 'Editar Autor' : 'Agregar Autor' }}</h2>

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
                    <label class="form-label">Nacionalidad</label>
                    <input v-model="form.nationality" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Año de nacimiento</label>
                    <input v-model="form.birth_year" type="number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Especialidades</label>
                    <input v-model="form.fields" type="text" class="form-control" required>
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

const authors = ref([])
const currentAuthor = ref({})
const view = ref('index') 

const form = ref({
    name: '',
    nationality: '',
    birth_year: '',
    fields: ''
})

const formErrors = ref([])
const successMessage = ref('')

const fetchAuthors = async () => {
    const res = await axios.get('/api/authors')
    authors.value = res.data
}

const showAuthor = async (id) => {
    const res = await axios.get(`/api/authors/${id}`)
    currentAuthor.value = res.data
    view.value = 'show'
}

const editAuthor = (author) => {
    form.value = { ...author }
    formErrors.value = []
    view.value = 'edit'
}

const switchToCreate = () => {
    form.value = {
        name: '',
        nationality: '',
        birth_year: '',
        fields: ''
    }
    formErrors.value = []
    view.value = 'create'
}

const submitForm = async () => {
    try {
        if (view.value === 'create') {
            await axios.post('/api/authors', form.value)
            successMessage.value = 'Autor creado exitosamente.'
        } else {
            await axios.put(`/api/authors/${form.value.id}`, form.value)
            successMessage.value = 'Autor actualizado exitosamente.'
        }
        await fetchAuthors()
        view.value = 'index'
        formErrors.value = []
    } catch (error) {
        if (error.response?.data?.errors) {
            formErrors.value = Object.values(error.response.data.errors).flat()
        }
    }
}

const deleteAuthor = async (id) => {
    if (confirm('¿Estás seguro de eliminar este autor?')) {
        await axios.delete(`/api/authors/${id}`)
        successMessage.value = 'Autor eliminado.'
        await fetchAuthors()
    }
}

onMounted(fetchAuthors)
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
