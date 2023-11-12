<!-- AreaAndSuburbDropdowns.vue -->
<template>
  <div class="area-suburb-dropdowns">
    <label for="area" class="dropdown-label">Select Area:</label>
    <select v-model="selectedArea" id="area" @change="handleAreaOrSuburbChange('area')" class="dropdown-select">
      <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.name }}</option>
    </select>

    <label for="suburb" class="dropdown-label">Select Suburb:</label>
    <select v-model="selectedSuburb" id="suburb" @change="handleAreaOrSuburbChange('suburb')" class="dropdown-select">
      <option v-for="suburb in suburbs" :key="suburb.id" :value="suburb.id">{{ suburb.name }} {{ suburb.postCode }}</option>
    </select>
  </div>
</template>

<script>
//import { ref, onMounted } from 'vue';
import ApiService from '@/services/api.service';

export default {
  data() {
    return {
      areas: [], // List of areas
      suburbs: [], // List of suburbs
      selectedArea: null, // Selected area
      selectedSuburb: null, // Selected suburb
    };
  },
  methods: {
    // Fetch areas on component mount
    fetchAreas() {
      ApiService.get('/sydney-areas') // /areas
          .then(response => {
            this.areas = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    },
    fetchSuburbs() {
      ApiService.getSuburbs()
          .then(response => {
            this.suburbs = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    },
    handleAreaOrSuburbChange(selectedDropdown) {
      const selectedArea = this.areas.find(area => area.id === this.selectedArea);
      const selectedSuburb = this.suburbs.find(suburb => suburb.id === this.selectedSuburb);

      this.$emit('areaOrSuburbSelected', {
        area: {
          id: selectedDropdown === 'area' ? this.selectedArea : null,
          name: selectedDropdown === 'area' ? selectedArea.name : null,
        },
        suburb: {
          id: selectedDropdown === 'suburb' ? this.selectedSuburb : null,
          name:  selectedDropdown === 'suburb' ? selectedSuburb.name : null,
        },
      });

      // Reset the value of the unselected dropdown
      if (selectedDropdown === 'area') {
        this.selectedSuburb = null;
        this.selectedSuburbName = null;
      } else {
        this.selectedArea = null;
        this.selectedAreaName = null;
      }

    },
  },
  // Fetch areas when the component is mounted
  mounted() {
    this.fetchAreas();
    this.fetchSuburbs();
  },
};
</script>

<style scoped>
.area-suburb-dropdowns {
  margin-bottom: 20px;
}

.dropdown-label {
  margin-right: 10px;
  font-weight: bold;
}

.dropdown-select {
  padding: 8px;
}
</style>