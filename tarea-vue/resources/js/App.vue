<template>
    <div id="app" class="d-flex flex-column min-vh-100">
        <HeaderComponent />

        <main class="flex-grow-1 py-4">
            <router-view />
        </main>

        <FooterComponent />
    </div>
</template>

<script setup>
import HeaderComponent from './components/Navbar.vue'
import FooterComponent from './components/Footer.vue'
</script>

<style>

html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
}
</style>