<template>
  <v-container class="table-container">
    <div class="d-flex justify-space-between pa-5">
      <h1 class="text-h4 d-flex ga-5 flex-column flex-md-row">
        USERS
        <v-btn
          v-if="route.fullPath == '/dashboard'"
          color="green-darken-3"
          @click="router.push('/dashboard/adduser')"
          >Add</v-btn
        >
        <v-btn v-else color="indigo-darken-1" @click="router.push('/dashboard')"
          >Dashboard</v-btn
        >
      </h1>
      <v-btn color="primary" @click="logout">LOG OUT</v-btn>
    </div>
  </v-container>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();

const logout = () => {
  localStorage.clear();
  router.push("/");
};
</script>