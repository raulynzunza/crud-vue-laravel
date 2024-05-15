<template>
  <td>{{ props.user.name }}</td>
  <td>{{ props.user.email }}</td>
  <td>{{ props.user.phone_number }}</td>
  <td>{{ props.user.city }}</td>
  <td class="d-flex ga-3 align-center justify-center">
    <v-btn color="red-darken-4" @click="$emit(props.onDelete(props.user.id))"
      >Delete</v-btn
    >
    <v-btn
      color="indigo-darken-1"
      @click="router.push('/dashboard/edituser/' + props.user.id)"
      >Update</v-btn
    >
  </td>
</template>

<script setup>
import axios from "../axios.js";
import { defineProps } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps(["user", "onDelete"]);
</script>