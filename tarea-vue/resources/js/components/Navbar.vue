<template>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5D4037">
    <div class="container">
      <a class="navbar-brand" href="/">📚 Biblioteca Virtual</a>
      
      <div class="d-flex">
        <router-link to="/books" class="btn btn-outline-light me-2">Libros</router-link>
        <router-link to="/authors" class="btn btn-outline-light me-2">Autores</router-link>
        <router-link to="/publishers" class="btn btn-outline-light">Editoriales</router-link>
      </div>
    </div>
  </nav>
</template>