<!-- AccommodationDetailModal.vue -->
<template>
  <div v-if="accommodation">
    <h2>{{ accommodation.name }}</h2>
    <p>{{ accommodation.description }}</p>
    <!-- Add more details as needed -->
    <button @click="closeModal" class="close-button">Close</button>
  </div>
</template>

<script>
export default {
  props: {
    accommodation: {
      type: Object,
      required: true,
    },
    onClose: {
      type: Function,
      required: true,
    },
  },
  methods: {
    closeModal() {
      this.onClose();
    },
  },
};
</script>

<style scoped>
.close-button {
  margin-top: 10px;
  padding: 5px 10px;
  cursor: pointer;
}
</style>