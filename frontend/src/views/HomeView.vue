<!-- App.vue -->
<template>
  <div class="home-background">
    <div class="home-container">
      <h2 class="home-title">Explore Sydney Accommodations</h2>
      <AreaAndSuburbDropdowns @areaOrSuburbSelected="handleAreaOrSuburbSelected" />
      <AccommodationList
          :selectedArea="selectedArea"
          :selectedSuburb="selectedSuburb"
          :selectedAreaName="selectedAreaName"
          :selectedSuburbName="selectedSuburbName"
      />
    </div>
  </div>
</template>

<script>
import AreaAndSuburbDropdowns from '@/components/AreaAndSuburbDropdowns.vue';
import AccommodationList from '@/components/AccommodationList.vue';

export default {
  components: {
    AreaAndSuburbDropdowns,
    AccommodationList,
  },
  data() {
    return {
      selectedArea: null,
      selectedSuburb: null,
      selectedAreaName: null,
      selectedSuburbName: null,
    };
  },
  methods: {
    handleAreaOrSuburbSelected({ area, suburb }) {
      this.selectedArea = area?.id;
      this.selectedSuburb = suburb?.id;
      this.selectedAreaName = area?.name;
      this.selectedSuburbName = suburb?.name;
    },
  },
};
</script>

<style scoped>
.home-background {
  background-color: #ffffff; /* White background outside the container */
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Shadow effect */
  min-height: 100vh; /* Ensures the background covers the full height of the viewport */
  display: flex;
  align-items: flex-start; /* Stick to the top */
  justify-content: center;
  padding-top: 20px; /* Add some margin at the top */
}

.home-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #4CAF50; /* Nice color for the container */
  border-radius: 8px;
}

.home-title {
  font-size: 2em;
  text-align: center;
  margin-top: 5px;
  margin-bottom: 20px;
  color: #ffffff; /* White text color for the title */
}
</style>
<style>

body {
  font-family: 'Comfortaa', sans-serif;
}
</style>