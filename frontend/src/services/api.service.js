// data.service.js
import axios from 'axios';

const ApiService = {
    // Set the base URL for your backend API
    baseURL: 'http://127.0.0.1:8000/api-mock', //uncomment to use the mock
    //baseURL: 'http://127.0.0.1:8000/api',    //uncomment to use the final api

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

    // Add more functions for different types of requests (POST, PUT, DELETE, etc.)
    // Example:
    // post(resource, data) {
    //   return axios.post(resource, data);
    // },
};

export default ApiService;
