<!-- AccommodationList.vue -->
<template>
  <div v-if="(selectedArea || selectedSuburb)">
    <div v-if="!selectedAccommodation">
      <h3 class="section-title">Accommodations in {{ (selectedAreaName ?? "") + (selectedAreaName &&  selectedSuburbName ? " or " : "") + ( selectedSuburbName ?? "") }}</h3>
      <ul class="accommodation-list">
        <li v-for="accommodation in accommodations" :key="accommodation.id" class="accommodation-item">
          <div class="accommodation-info">
            <img :src="accommodation.image" alt="Accommodation Image" class="accommodation-image" />
            <div class="accommodation-details">
              <div class="name-box">
                <span class="name">{{ accommodation.name }}</span>
              </div>
              <div class="description-box">
                <span class="description">{{ truncateDescription(accommodation.description) }}</span>
              </div>
              <button @click="viewDetails(accommodation)" class="details-button">View Details</button>
            </div>
          </div>
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
      type: ApiService.isUsingMockApi() ? Number : String,
      required: false,
    },
    selectedSuburbName: {
      type: String,
      required: false,
    },
    selectedArea: {
      type: ApiService.isUsingMockApi() ? Number : String,
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
      ApiService.get(`/accommodations?suburb=${this.selectedSuburb}&area=${this.selectedArea}&page=${newPage}`)
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
    // Truncate description if it's longer than 200 characters
    truncateDescription(description) {
      if (description.length > 200) {
        return description.substring(0, 200) + '...';
      }
      return description;
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
  position: relative; /* Set position to relative */
}

.accommodation-info {
  display: flex;
  align-items: flex-start; /* Align items to the top */
}

.accommodation-image {
  max-width: 250px; /* Adjusted to be 2.5 times bigger */
  margin-right: 10px;
}

.accommodation-details {
  flex-grow: 1;
  display: flex;
  flex-direction: column; /* Stack items vertically */
  justify-content: flex-start; /* Align items to the top */
}

.name-box {
  width: 100%;
  margin-bottom: 5px;
}

.name {
  font-weight: bold;
}

.description-box {
  width: 100%;
  margin-bottom: 10px;
}

.description {
  text-align: right;
  max-height: 40px; /* Limit the height of description */
  overflow: hidden;
}

.details-button {
  position: absolute; /* Set position to absolute */
  bottom: 0; /* Align to the bottom */
  right: 0; /* Align to the right */
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

/* Responsive styles for narrower screens */
@media only screen and (max-width: 600px) {
  .section-title {
    font-size: 1.2em!important;;
    color:red!important;;
  }

  .accommodation-item {
    font-size: 0.9em!important;;
  }

  .accommodation-image {
    max-width: 200px; /* Adjusted to be 2.5 times bigger */
    margin-right: 10px;
  }

  .details-button {
    margin-left: 5px;
    padding: 3px 6px;
  }

  .pagination {
    margin-top: 5px;
  }

  .page-button {
    padding: 3px 6px;
    margin-right: 3px;
  }

  .page-info {
    font-size: 0.9em;
  }
}
</style>



