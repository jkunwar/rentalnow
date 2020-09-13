import React from 'react';
import 'antd/dist/antd.css';
import ReactDOM from 'react-dom';
import App from './components/App';
import { Provider } from 'react-redux';
import store, { persistor } from './store';
import { BrowserRouter as Router } from 'react-router-dom';
import { PersistGate } from 'redux-persist/integration/react';
import * as storage from './utils/storage';
import { ACCESS_TOKEN } from './constants/storage';

setAuthorizationToken(storage.get(ACCESS_TOKEN));

function setAuthorizationToken(token) {
  if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  } else {
    delete axios.defaults.headers.common['Authorization']
  }
}


if (document.getElementById('app')) {

  ReactDOM.render(
    <PersistGate persistor={persistor}>
      <Router>
        <Provider store={store}>
          <App />
        </Provider>
      </Router>
    </PersistGate>, document.getElementById('app'));
}