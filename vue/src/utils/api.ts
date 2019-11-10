/* eslint-disable no-param-reassign */

import axios from 'axios';
import { getAccessToken, refreshToken } from './auth';

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
});

instance.interceptors.request.use((config) => {
  const token = getAccessToken();
  config.headers.Authorization = `Bearer ${token}`;
  return config;
}, (error) => {
  console.log(error);
});

instance.interceptors.response.use(undefined, async (error) => {
  if (error.config && error.response && error.response.status === 401) {
    await refreshToken();
    const token = getAccessToken();
    error.config.headers.Authorization = `Bearer ${token}`;
    return axios.request(error.config);
  }

  return Promise.reject(error);
});

export default instance;
