<template>
  <v-container class="d-flex flex-column align-center">
    <h2 class="text-h5 mb-6">Edit User</h2>
    <form @submit.prevent="onEditUser" class="w-50">
      <v-text-field v-model="name" label="Name"></v-text-field>

      <v-text-field v-model="email" label="E-mail"></v-text-field>

      <v-text-field v-model="phone_number" label="Phone Number"></v-text-field>

      <v-text-field v-model="city" label="City"></v-text-field>

      <v-btn class="me-4" type="submit" color="blue-darken-3">Edit</v-btn>
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
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const loading = ref(false);

const id = ref();
const name = ref();
const email = ref();
const phone_number = ref();
const city = ref();

const snackbar = ref({
  status: false,
  timeout: 3000,
  text: "",
  color: "",
});

const route = useRoute();

const onEditUser = async () => {
  loading.value = true;

  try {
    await axios.put("/users/" + id.value, {
      name: name.value,
      email: email.value,
      phone_number: phone_number.value,
      city: city.value,
    });

    snackbar.value.text = "User updated successfully!";
    snackbar.value.color = "blue-darken-2";
    snackbar.value.status = true;
  } catch (error) {
    snackbar.value.text = error.response.data.message;
    snackbar.value.color = "red";
    snackbar.value.status = true;
  }

  loading.value = false;
};

onMounted(async () => {
  try {
    const resp = await axios.get("/users/" + route.params.id);
    id.value = resp.data.user.id;
    name.value = resp.data.user.name;
    email.value = resp.data.user.email;
    phone_number.value = resp.data.user.phone_number;
    city.value = resp.data.user.city;
  } catch (error) {
    console.log(error);
  }
});
</script>
  
  <style scoped>
form {
  max-width: 900px;
}
</style>