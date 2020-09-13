import * as storage from '../utils/storage';
import * as authServices from '../services/auth';
import { put, call, all, takeLatest, delay } from 'redux-saga/effects';
import { actionTypes, actions as loginActions } from '../actions/auth';
import { ACCESS_TOKEN, REFRESH_TOKEN } from '../constants/storage';
import config from '../config';

function* login(action) {
  yield delay(400);

  const response = yield call(authServices.login, action.credentials);

  if (response.payload) {

    yield put(loginActions.loginSuccess(response.payload, response.status));
    storage.set(ACCESS_TOKEN, response.payload.access_token);
    storage.set(REFRESH_TOKEN, response.payload.refresh_token);
    storage.set('user', response.payload.user);
    storage.set('image', response.payload.image);

    window.location.href = `${config.baseURI}`;

    return;
  }

  yield put(loginActions.loginFailure(response.error, response.status));

  return;
}

function* logout(action) {
  yield delay(400);

  const response = yield call(authServices.logout, action);

  if (response.status === 204) {
    storage.remove(ACCESS_TOKEN);
    storage.remove(REFRESH_TOKEN);
    storage.remove('user');
    yield put(loginActions.logoutSuccess());
    window.location.href = `${config.baseURI}`;

    return;
  }

  console.log(response)

}

export default function* root() {
  yield all([
    takeLatest(actionTypes.LOGIN_USER, login),
    takeLatest(actionTypes.LOGOUT_USER, logout)
  ]);
}