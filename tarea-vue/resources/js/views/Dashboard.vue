

<script setup>

import Navbar from '../components/Navbar.vue' 
import Footer from '../components/Footer.vue'

</script> 

<template>
    <div>
      
         <div class="py-5">
            <div class="container">
            
                <h2 class="text-center fw-bold mb-4">Bienvenido al Dashboard</h2>

                <div class="card shadow-sm mb-5">
                    <div class="card-body text-center">
                        <h3 class="h5 fw-bold mb-3">¡Bienvenido al panel de administración de tu librería!</h3>
                        <p class="text-muted">Aquí puedes gestionar tus libros, autores y editoriales.</p>

                     
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3">
                                <router-link to="/books" class="btn btn-primary btn-lg w-100">
                                    📚 Libros
                                </router-link>
                            </div>
                            <div class="col-md-4 mb-3">
                                <router-link to="/authors" class="btn btn-success btn-lg w-100">
                                    👨‍🏫 Autores
                                </router-link>
                            </div>
                            <div class="col-md-4 mb-3">
                                <router-link to="/publishers" class="btn btn-info btn-lg w-100">
                                    🏢 Editoriales
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  
    </div>

 </template>

    <style scoped>
        /* Opcional: estilos personalizados */
    </style>
