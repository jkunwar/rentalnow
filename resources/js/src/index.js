import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App';
import { Provider } from 'react-redux';
import store, { persistor } from './store';
import { BrowserRouter as Router } from 'react-router-dom';
import 'antd/dist/antd.css';
import { PersistGate } from 'redux-persist/integration/react';

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