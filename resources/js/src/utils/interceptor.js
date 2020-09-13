import axios from 'axios';
import config from '../config';
import * as storage from './utils/storage';
import { ACCESS_TOKEN, REFRESH_TOKEN } from '../constants/storage';

axios.interceptors.request.use(function (config) {
    return config;
}, function (error) {
    return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    let originalRequest = error.config;
    if (error.response.status === 401
        && !originalRequest._retry
        && error.response.data.message !== 'The user credentials were incorrect.'
        && error.response.data.message !== 'The refresh token is invalid.'
        && error.response.data.message !== 'Your account is suspended.'
    ) {
        originalRequest._retry = true;
        var refreshToken = localStorage.getItem('refresh_token');
        const credentials = {
            refresh_token: refreshToken
        }
        return axios.post(`${config.baseURI}/refresh-token`, credentials)
            .then(({ data }) => {
                storage.set(ACCESS_TOKEN, data.data.access_token);
                storage.set(REFRESH_TOKEN, data.data.refresh_token);
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.data.access_token;
                originalRequest.headers['Authorization'] = 'Bearer ' + data.data.access_token;
                return axios(originalRequest);
            });

    } else if (error.response.status === 401 && error.response.data.message == 'The refresh token is invalid.') {
        storage.clear()
        window.location.reload();
    }

    return Promise.reject(error);
});
