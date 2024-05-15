<template>
  <v-container class="table-container h-screen">
    <v-table class="bg-transparent h-75" v-if="!loading">
      <thead>
        <tr>
          <th class="text-left font-weight-black">Name</th>
          <th class="text-left font-weight-black">Email</th>
          <th class="text-left font-weight-black">Phone number</th>
          <th class="text-left font-weight-black">City</th>
          <th class="text-center font-weight-black">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.name">
          <TableRow :user="user" :onDelete="onDelete" />
        </tr>
      </tbody>
    </v-table>
    <div class="spinner-container" v-else>
      <v-progress-circular model-value="20" indeterminate></v-progress-circular>
    </div>
  </v-container>
</template>
<script setup>
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import TableRow from "./TableRow.vue";
import axios from "../axios.js";

const users = ref();
const loading = ref(true);
const router = useRouter();

const onDelete = async (id) => {
  try {
    await axios.delete("/users/" + id, {
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    setUserList();
  } catch (error) {
    console.error(error);
  }
};

const setUserList = async () => {
  const resp = await axios.get("/users");

  loading.value = false;
  users.value = resp.data;
};

onBeforeMount(async () => {
  try {
    setUserList();
  } catch (error) {
    if (error.response.status == 401) {
      localStorage.clear();
      router.push("/");
    }
  }
});
</script>

<style scoped>
.table-container {
  max-width: 1080px;
}

.spinner-container {
  display: flex;
  height: 75vh;
  justify-content: center;
  align-items: center;
}
</style>
