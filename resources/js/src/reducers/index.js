import { combineReducers } from 'redux';
import { persistReducer } from 'redux-persist';
import storage from 'redux-persist/lib/storage';

import { login } from './auth';

/**
 * Persist login Reducer.
 */
const authPersistConfig = {
  key: 'login',
  storage: storage,
};

export default combineReducers({
  login: persistReducer(authPersistConfig, login)
});
