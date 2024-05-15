<template>
  <Navbar v-if="!excludedRoutes.includes(route.fullPath)" />
  <router-view></router-view>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import Navbar from "./components/Navbar.vue";
import { onBeforeMount } from "vue";

const route = useRoute();
const router = useRouter();

const excludedRoutes = ["/", "/register"];

onBeforeMount(() => {
  if (!localStorage.getItem("token")) {
    router.push("/");
  } else {
    router.push("/dashboard");
  }
});
</script>
