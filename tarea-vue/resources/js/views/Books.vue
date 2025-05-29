<template>
  <div class="container mt-4">
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
              <th>Lenguaje</th>
              <th>Páginas</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books" :key="book.id">
              <td>{{ book.id }}</td>
              <td>{{ book.title }}</td>
              <td>{{ book.edition }}</td>
              <td>{{ book.language }}</td>
              <td>{{ book.pages }}</td>
              <td>
                <button class="btn btn-info btn-sm" @click="showBook(book.id)">👁 Ver</button>
                <button class="btn btn-warning btn-sm" @click="editBook(book)">✏️ Editar</button>
                <button class="btn btn-danger btn-sm" @click="deleteBook(book.id)">🗑 Eliminar</button>
              </td>
            </tr>
            <tr v-if="books.length === 0">
              <td colspan="6" class="text-center">No hay libros registrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-else-if="view === 'show'">
      <h2>Detalles del Libro</h2>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ currentBook.title }}</h4>
          <p><strong>Edición:</strong> {{ currentBook.edition }}</p>
          <p><strong>Copyright:</strong> {{ currentBook.copyright }}</p>
          <p><strong>Lenguaje:</strong> {{ currentBook.language }}</p>
          <p><strong>Páginas:</strong> {{ currentBook.pages }}</p>
          <p><strong>Autor:</strong> {{ currentBook.author?.name }}</p>
          <p><strong>Editorial:</strong> {{ currentBook.publisher?.name }}</p>
        </div>
      </div>
      <button class="btn btn-secondary mt-3" @click="view = 'index'">← Volver a la lista</button>
    </div>

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
          <input v-model="form.title" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Edición</label>
          <input v-model="form.edition" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Copyright</label>
          <input v-model="form.copyright" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Lenguaje</label>
          <input v-model="form.language" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Páginas</label>
          <input v-model="form.pages" type="number" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Autor</label>
          <select v-model="form.author_id" class="form-select" required>
            <option disabled value="">Seleccione un autor</option>
            <option v-for="author in authors" :value="author.id" :key="author.id">{{ author.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Editorial</label>
          <select v-model="form.publisher_id" class="form-select" required>
            <option disabled value="">Seleccione una editorial</option>
            <option v-for="publisher in publishers" :value="publisher.id" :key="publisher.id">{{ publisher.name }}</option>
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
const currentBook = ref({})
const authors = ref([])
const publishers = ref([])
const view = ref('index')

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

const fetchBooks = async () => {
  const res = await axios.get('/api/books')
  books.value = res.data
}

const fetchAuthorsAndPublishers = async () => {
  const [a, p] = await Promise.all([
    axios.get('/api/authors'),
    axios.get('/api/publishers')
  ])
  authors.value = a.data
  publishers.value = p.data
}

const showBook = async (id) => {
  const res = await axios.get(`/api/books/${id}`)
  currentBook.value = res.data
  view.value = 'show'
}

const editBook = (book) => {
  form.value = { ...book }
  formErrors.value = []
  view.value = 'edit'
}

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

const deleteBook = async (id) => {
  if (confirm('¿Estás seguro de eliminar este libro?')) {
    await axios.delete(`/api/books/${id}`)
    successMessage.value = 'Libro eliminado.'
    await fetchBooks()
  }
}

onMounted(async () => {
  await fetchAuthorsAndPublishers()
  await fetchBooks()
})
</script>

<style scoped>
.form-label {
  font-weight: bold;
}
.form-control, .form-select {
  border-radius: 10px;
  padding: 10px;
}
.btn {
  margin-right: 0.5rem;
}
</style>
