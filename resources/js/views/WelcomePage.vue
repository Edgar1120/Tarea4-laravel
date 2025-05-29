<template>
  <div>
  

    <div class="content-wrapper">
      <header class="text-center" style="background: linear-gradient(to bottom right, #FFF3E0, #FFEBEE); color: #4E342E; padding: 60px 0;">
        <div class="container">
          <h1 class="display-4 fw-bold">Bienvenido a la Biblioteca Virtual</h1>
          <p class="lead">Explora libros, autores y editoriales fácilmente.</p>
          <router-link to="/dashboard" class="btn btn-primary btn-lg mt-3">Biblioteca</router-link>
        </div>
      </header>

      <section class="container py-5">
        <div class="row text-center">
          <div class="col-md-4">
            <h3>📘 Libros</h3>
            <p>Consulta todos los libros disponibles en la base de datos.</p>
          </div>
          <div class="col-md-4">
            <h3>👨‍🏫 Autores</h3>
            <p>Conoce a los autores de tus libros favoritos.</p>
          </div>
          <div class="col-md-4">
            <h3>🏢 Editoriales</h3>
            <p>Explora las editoriales que publican estos libros.</p>
          </div>
        </div>
      </section>
    </div>

  
  </div>
</template>

<script setup>
import { ref } from 'vue'

const currentYear = new Date().getFullYear()
</script>

<style scoped>
.content-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
.btn-primary {
  background-color: #8D6E63;
  border-color: #8D6E63;
}
.btn-primary:hover {
  background-color: #6D4C41;
  border-color: #6D4C41;
}
</style>