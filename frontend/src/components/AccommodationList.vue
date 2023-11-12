<!-- AccommodationList.vue -->
<template>
  <div v-if="(selectedArea || selectedSuburb)">
    <div v-if="!selectedAccommodation">
      <h3 class="section-title">Accommodations in {{ (selectedAreaName ?? "") + (selectedAreaName &&  selectedSuburbName ? " or " : "") + ( selectedSuburbName ?? "") }}</h3>
      <ul class="accommodation-list">
        <li v-for="accommodation in accommodations" :key="accommodation.id" class="accommodation-item">
          {{ accommodation.name }} - {{ accommodation.description }}
          <button @click="viewDetails(accommodation)" class="details-button">View Details</button>
        </li>
      </ul>

      <div v-if="totalPages > 1" class="pagination">
        <button @click="fetchAccommodations(page - 1)" :disabled="page === 1" class="page-button">Previous</button>
        <span class="page-info">Page {{ page }} of {{ totalPages }}</span>
        <button @click="fetchAccommodations(page + 1)" :disabled="page === totalPages" class="page-button">Next</button>
      </div>
    </div>
    <AccommodationDetailModal
        v-if="selectedAccommodation"
        :accommodation="selectedAccommodation"
        :onClose="closeModal"
    />
  </div>
  <div v-if="!(selectedArea || selectedSuburb)" class="no-selection-message">
    <h3>Please first select an area or suburb!</h3>
  </div>
</template>


<script>
import AccommodationDetailModal from '@/components/AccommodationDetailModal.vue';
import ApiService from "@/services/api.service";

export default {
  components: {
    AccommodationDetailModal,
  },
  props: {
    selectedSuburb: {
      type: Number,
      required: false,
    },
    selectedSuburbName: {
      type: String,
      required: false,
    },
    selectedArea: {
      type: Number,
      required: false,
    },
    selectedAreaName: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      accommodations: [], // List of accommodations
      page: 1, // Current page
      totalPages: 1, // Total number of pages
      selectedAccommodation: null, // Selected accommodation
    };
  },
  // Fetch accommodations when the component is mounted or when the selected suburb changes
  watch: {
    selectedArea: 'fetchAccommodations',
    selectedSuburb: 'fetchAccommodations',
  },
  methods: {
    // Fetch accommodations based on the selected suburb and page
    // eslint-disable-next-line no-unused-vars
    fetchAccommodations(newPage = 1) {
      ApiService.get(`/accommodations?suburbId=${this.selectedSuburb}&areaId=${this.selectedArea}&page=${newPage}`)
          .then(response => {
            this.accommodations = response.data.results;
            this.totalPages = response.data.totalPages;
            this.page = newPage;
          })
          .catch(error => {
            console.error(error);
          });
    },
    // Open modal and set the selected accommodation
    viewDetails(accommodation) {
      this.selectedAccommodation = accommodation;
    },
    // Close modal and reset selected accommodation
    closeModal() {
      this.selectedAccommodation = null;
    },
  },
  // Fetch accommodations when the component is mounted
  mounted() {
    this.fetchAccommodations();
  },
};
</script>

<style scoped>
.section-title {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.accommodation-list {
  list-style-type: none;
  padding: 0;
}

.accommodation-item {
  margin-bottom: 10px;
}

.details-button {
  margin-left: 10px;
  padding: 5px 10px;
}

.pagination {
  margin-top: 10px;
}

.page-button {
  padding: 5px 10px;
  margin-right: 5px;
  cursor: pointer;
}

.page-info {
  font-weight: bold;
}

.no-selection-message {
  margin-top: 20px;
}
</style>