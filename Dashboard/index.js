import React from 'react';
import { BrowserRouter as Router, Route } from 'react-router-dom';

const HomePage = () => <h1>Trang chủ</h1>;
const AboutPage = () => <h1>Giới thiệu</h1>;

const App = () => (
  <Router>
    <Route path="/" exact component={HomePage} />
    <Route path="/about" component={AboutPage} />
  </Router>
);

export default App;