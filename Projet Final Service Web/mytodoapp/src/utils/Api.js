import axios from 'axios';

const BASE_URL = 'http://127.0.0.1/ProjetFinalAPI/'; // URL de base de l'API

const apiKey = 'abc123';

const Api = axios.create({
  baseURL: BASE_URL,
  headers: {
    Authorization: 'Bearer ' + apiKey,
  },
});

export default Api;
