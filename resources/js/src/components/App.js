import React from 'react';
import { Route, Switch } from "react-router-dom";
import Welcome from './Welcome';

const App = () => {

  return (
    <Switch>
      <Route path="/" component={Welcome} />
    </Switch>
  );

}

export default App;
