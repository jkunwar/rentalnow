import { persistStore } from 'redux-persist';
import createSagaMiddleware from 'redux-saga';
import { compose, createStore, applyMiddleware } from 'redux';

import rootReducer from './reducers';

import authSaga from './sagas/authSaga';

const sagaMiddleware = createSagaMiddleware();

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const composedEnhancers = composeEnhancer(
  applyMiddleware(sagaMiddleware),
);

let store = createStore(
  rootReducer,
  composedEnhancers,
);

const persistor = persistStore(store);

sagaMiddleware.run(authSaga);

export default store;
export { persistor };