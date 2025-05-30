<template>
  <div class="container mt-4">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></link>
    <!-- INDEX -->
    <div v-if="view === 'index'">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Libros</h2>
        <button @click="switchToCreate" class="btn btn-success">➕ Agregar Libro</button>
      </div>

      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Edición</th>
              <th>Copyright</th>
              <th>Idioma</th>
              <th>Páginas</th>
              <th>Autor</th>
              <th>Editorial</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books" :key="book.id">
              <td>{{ book.id }}</td>
              <td>{{ book.title }}</td>
              <td>{{ book.edition }}</td>
              <td>{{ book.copyright }}</td>
              <td>{{ book.language }}</td>
              <td>{{ book.pages }}</td>
              <td>{{ getAuthorName(book.author_id) }}</td>
              <td>{{ getPublisherName(book.publisher_id) }}</td>
            <td>
  <div class="d-flex gap-1">
    <button class="btn btn-outline-info btn-sm" @click="showBook(book.id)" title="Ver">
      <i class="bi bi-eye"></i>
    </button>
    <button class="btn btn-outline-warning btn-sm" @click="editBook(book)" title="Editar">
      <i class="bi bi-pencil-square"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm" @click="deleteBook(book.id)" title="Eliminar">
      <i class="bi bi-trash"></i>
    </button>
  </div>
</td>
            </tr>
            <tr v-if="books.length === 0">
              <td colspan="9" class="text-center">No hay libros registrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- SHOW -->
    <div v-else-if="view === 'show'">
      <h2>Detalles del Libro</h2>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ currentBook.title }}</h4>
          <p><strong>Edición:</strong> {{ currentBook.edition }}</p>
          <p><strong>Copyright:</strong> {{ currentBook.copyright }}</p>
          <p><strong>Idioma:</strong> {{ currentBook.language }}</p>
          <p><strong>Páginas:</strong> {{ currentBook.pages }}</p>
          <p><strong>Autor:</strong> {{ getAuthorName(currentBook.author_id) }}</p>
          <p><strong>Editorial:</strong> {{ getPublisherName(currentBook.publisher_id) }}</p>
        </div>
      </div>
      <button class="btn btn-secondary mt-3" @click="view = 'index'">← Volver a la lista</button>
    </div>

    <!-- FORMULARIO (EDIT / CREATE) -->
    <div v-else-if="view === 'edit' || view === 'create'">
      <h2 class="text-center">{{ view === 'edit' ? 'Editar Libro' : 'Agregar Libro' }}</h2>

      <div v-if="formErrors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in formErrors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input v-model="form.title" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Edición</label>
          <input v-model="form.edition" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Copyright</label>
          <input v-model="form.copyright" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Idioma</label>
          <input v-model="form.language" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Páginas</label>
          <input v-model="form.pages" type="number" class="form-control" required />
        </div>

        <!-- Select Autor -->
        <div class="mb-3">
          <label class="form-label">Autor</label>
          <select v-model="form.author_id" class="form-control" required>
            <option value="" disabled>Seleccione un autor</option>
            <option v-for="author in authors" :key="author.id" :value="author.id">
              {{ author.name }}
            </option>
          </select>
        </div>

        <!-- Select Editorial -->
        <div class="mb-3">
          <label class="form-label">Editorial</label>
          <select v-model="form.publisher_id" class="form-control" required>
            <option value="" disabled>Seleccione una editorial</option>
            <option v-for="publisher in publishers" :key="publisher.id" :value="publisher.id">
              {{ publisher.name }}
            </option>
          </select>
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

const books = ref([])
const authors = ref([])
const publishers = ref([])

const view = ref('index')
const currentBook = ref({})

const form = ref({
  title: '',
  edition: '',
  copyright: '',
  language: '',
  pages: '',
  author_id: '',
  publisher_id: ''
})

const formErrors = ref([])
const successMessage = ref('')

// Obtener nombre de autor
const getAuthorName = (id) => {
  const author = authors.value.find(a => a.id === id)
  return author ? author.name : 'Desconocido'
}

// Obtener nombre de editorial
const getPublisherName = (id) => {
  const publisher = publishers.value.find(p => p.id === id)
  return publisher ? publisher.name : 'Desconocido'
}

// Mostrar detalle
const showBook = async (id) => {
  const res = await axios.get(`/api/books/${id}`)
  currentBook.value = res.data
  view.value = 'show'
}

// Cargar datos
const fetchBooks = async () => {
  const res = await axios.get('/api/books')
  books.value = res.data
}
const fetchAuthors = async () => {
  const res = await axios.get('/api/authors')
  authors.value = res.data
}
const fetchPublishers = async () => {
  const res = await axios.get('/api/publishers')
  publishers.value = res.data
}

// Cambiar a crear
const switchToCreate = () => {
  form.value = {
    title: '',
    edition: '',
    copyright: '',
    language: '',
    pages: '',
    author_id: '',
    publisher_id: ''
  }
  formErrors.value = []
  view.value = 'create'
}

// Editar
const editBook = (book) => {
  form.value = { ...book }
  formErrors.value = []
  view.value = 'edit'
}

// Guardar
const submitForm = async () => {
  try {
    if (view.value === 'create') {
      await axios.post('/api/books', form.value)
      successMessage.value = 'Libro creado exitosamente.'
    } else {
      await axios.put(`/api/books/${form.value.id}`, form.value)
      successMessage.value = 'Libro actualizado exitosamente.'
    }
    await fetchBooks()
    view.value = 'index'
    formErrors.value = []
  } catch (error) {
    if (error.response?.data?.errors) {
      formErrors.value = Object.values(error.response.data.errors).flat()
    }
  }
}

// Eliminar
const deleteBook = async (id) => {
  if (confirm('¿Estás seguro de eliminar este libro?')) {
    await axios.delete(`/api/books/${id}`)
    successMessage.value = 'Libro eliminado.'
    await fetchBooks()
  }
}

// Cargar datos iniciales
onMounted(async () => {
  await fetchBooks()
  await fetchAuthors()
  await fetchPublishers()
})
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
