<template>
    <footer class="text-center text-white py-3" style="background-color: #5D4037">
        <div class="container">
            <p>&copy; {{ currentYear }} Biblioteca Virtual. Todos los derechos reservados.</p>
        </div>
    </footer>
</template>

<script setup>const currentYear = new Date().getFullYear(); </script>
<style scoped>

</style>