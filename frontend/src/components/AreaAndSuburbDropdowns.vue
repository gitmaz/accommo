<!-- AreaAndSuburbDropdown.vue -->
<template>
  <div>
    <label for="areaDropdown">Select Area: </label>
    <select id="areaDropdown" v-model="selectedArea" @change="fetchAreaSuburbs">
      <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.name }}</option>
    </select>

    <label for="suburbDropdown">&nbsp;&nbsp;Select Suburb: </label>
    <select id="suburbDropdown" v-model="selectedSuburb" @change="handleAreaOrSuburbChange('suburb')">
      <option v-for="suburb in suburbs" :key="suburb.id" :value="suburb.id">{{ suburb.name }}</option>
    </select>
  </div>
</template>

<script>
import ApiService from '@/services/api.service';

export default {
  data() {
    return {
      areas: [],
      suburbs: [],
      selectedArea: null,
      selectedSuburb: null,
    };
  },
  methods: {
    // Fetch areas when the component is mounted
    fetchAreas() {
      ApiService.get('/sydney-areas')
          .then(response => {
            this.areas = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    },

    // Fetch suburbs based on the selected area
    fetchAreaSuburbs() {
      if (this.selectedArea) {
        ApiService.getAreaSuburbs(this.selectedArea)
            .then(response => {
              this.suburbs = response.data;
            })
            .catch(error => {
              console.error(error);
            });

        this.handleAreaOrSuburbChange('area')
      }
    },

    handleAreaOrSuburbChange(selectedDropdown) {

      /*if(selectedDropdown === 'suburb'){
        console.log(this.selectedSuburb);
        return;
      }*/

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
      }

    },
  },
  // Fetch areas when the component is mounted
  mounted() {
    this.fetchAreas();
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
