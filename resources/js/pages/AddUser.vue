<template>
  <v-container class="d-flex flex-column align-center">
    <h2 class="text-h5 mb-6">Add new user</h2>
    <form @submit.prevent="onAddUser" class="w-50">
      <v-text-field v-model="name" label="Name"></v-text-field>

      <v-text-field v-model="email" label="E-mail"></v-text-field>

      <v-text-field
        v-model="password"
        label="Password"
        type="password"
      ></v-text-field>

      <v-text-field v-model="phone_number" label="Phone Number"></v-text-field>

      <v-text-field v-model="city" label="City"></v-text-field>

      <v-btn class="me-4" type="submit" color="green-darken-3">Add</v-btn>
    </form>
    <v-progress-circular
      model-value="20"
      indeterminate
      v-if="loading"
    ></v-progress-circular>
  </v-container>

  <v-snackbar
    v-model="snackbar.status"
    :timeout="snackbar.timeout"
    :color="snackbar.color"
  >
    {{ snackbar.text }}
  </v-snackbar>
</template>

<script setup>
import axios from "../axios.js";
import { ref } from "vue";

const loading = ref(false);

const name = ref();
const email = ref();
const password = ref();
const phone_number = ref();
const city = ref();

const snackbar = ref({
  status: false,
  timeout: 3000,
  text: "",
  color: "",
});

const onAddUser = async () => {
  loading.value = true;

  try {
    await axios.post("/users", {
      name: name.value,
      email: email.value,
      password: password.value,
      phone_number: phone_number.value,
      city: city.value,
    });

    snackbar.value.text = "User created successfully!";
    snackbar.value.color = "success";
    snackbar.value.status = true;

    name.value = "";
    email.value = "";
    password.value = "";
    phone_number.value = "";
    city.value = "";
  } catch (error) {
    snackbar.value.text = error.response.data.message;
    snackbar.value.color = "red";
    snackbar.value.status = true;
  }

  loading.value = false;
};
</script>

<style scoped>
form {
  max-width: 900px;
}
</style>