import * as api from '../Api/rentalNowApi';

export function login({ provider, callbackToken }) {

  return api.call('GET', `/login/${provider}/callback${callbackToken}`);

}

export function logout() {
  return api.call('POST', `/logout`)
}