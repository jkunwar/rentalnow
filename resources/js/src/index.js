import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App';
import { Provider } from 'react-redux';
import store, { persistor } from './store';
import { BrowserRouter as Router } from 'react-router-dom';
import 'antd/dist/antd.css';

if (document.getElementById('app')) {

  ReactDOM.render(
    <Router>
      <Provider store={store}>
        <App />
      </Provider>
    </Router>, document.getElementById('app'));
}