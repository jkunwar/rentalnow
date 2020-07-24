import * as storage from '../utils/storage';
import * as authServices from '../services/auth';
import { put, call, all, takeLatest, delay } from 'redux-saga/effects';
import { actionTypes, actions as loginActions } from '../actions/auth';
import { ACCESS_TOKEN, REFRESH_TOKEN } from '../constants/storage';

function* login(action) {
  yield delay(400);

  const response = yield call(authServices.login, action.credentials);

  if (response.payload) {

    yield put(loginActions.loginSuccess(response.payload, response.status));
    storage.set(ACCESS_TOKEN, response.payload.access_token);
    storage.set(REFRESH_TOKEN, response.payload.refresh_token);
    storage.set('user', response.payload.user);
    return;
  }

  yield put(loginActions.loginFailure(response.error, response.status));

  return;
}

export default function* root() {
  yield all([
    takeLatest(actionTypes.LOGIN_USER, login)
  ]);
}