import axios from 'axios';

const RANDOM_USER_API_URL = 'https://randomuser.me/api';

const ExternalApiService = {
  getRandomUser: async () => {
    const response = await axios.get(RANDOM_USER_API_URL);
    return response.data.results[0];
  },
};

export default ExternalApiService;
