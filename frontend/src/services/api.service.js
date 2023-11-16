// api.service.js
import axios from 'axios';

const isApiMock = false; // set to false to use real api, true to use mock api (useful for ui development detached from ATLAS)

const ApiService = {
    isApiMock: isApiMock, // set to false to use the real api version
    // Set the base URL for your backend API
    //baseURL: isApiMock ? 'http://127.0.0.1:8000/api-mock' : 'http://127.0.0.1:8000/api',
    baseURL: isApiMock ? 'http://54.79.206.109/api-mock' : 'http://54.79.206.109/api',

    // Function to initialize the API service with the base URL
    init() {
        axios.defaults.baseURL = this.baseURL;
    },

    // Generic function for making GET requests
    get(resource) {
        return axios.get(resource);
    },

    // New function to fetch suburbs based on the selected area
    getSuburbs() {
        return this.get(`/suburbs`);
    },

    // New function to fetch suburbs based on the selected area
    getAreaSuburbs(areaId) {
        return this.get(`/sydney-area-suburbs?area=${areaId}&XDEBUG_SESSION_START=16070`);
    },

    isUsingMockApi() {
        return isApiMock;
    },
};

export default ApiService;
