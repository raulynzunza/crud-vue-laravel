<template>
  <v-form
    @submit.prevent="onSubmit()"
    class="h-screen d-flex justify-center align-center"
  >
    <v-container class="d-flex justify-center align-center flex-column form">
      <v-col
        class="d-flex justify-center flex-column v-col-6 ga-5 bg-blue-grey-lighten-4 rounded-xl pa-16"
      >
        <h1 class="text-center">Login</h1>
        <v-row>
          <v-text-field
            v-model="email"
            label="Email"
            type="email"
            hide-details
            required
          ></v-text-field>
        </v-row>

        <v-row>
          <v-text-field
            v-model="password"
            label="Passsword"
            hide-details
            type="password"
            required
          ></v-text-field>
        </v-row>
        <v-btn type="submit" color="primary">Login</v-btn>
        <v-btn type="submit" @click="router.push('/register')">Register</v-btn>
        <v-row> </v-row>
      </v-col>
      <v-alert
        v-if="errorFlag.status"
        class="v-col-6 mt-4"
        color="error"
        icon="$vuetify"
        title="Error"
        :text="errorFlag.message"
      ></v-alert>
    </v-container>
  </v-form>
</template>

<script setup>
import axios from "../axios.js";
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const errorFlag = ref({
  status: false,
  message: "",
});

const router = useRouter();

const onSubmit = async () => {
  if (!email.value || !password.value) return;

  try {
    const resp = await axios.post("/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", resp.data.token);

    axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${resp.data.token}`;

    router.push("/dashboard");
  } catch (error) {
    errorFlag.value.status = true;
    errorFlag.value.message = error.response.data.message;
  }
};
</script>

<style scoped>
h1 {
  font-size: 1.7rem;
}
.form {
  max-width: 1080px;
}
</style>