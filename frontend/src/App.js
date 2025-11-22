import React from 'react';
import DishList from './components/DishList';
import './App.css';

function App() {
  return (
    <div className="App">
      <div className="container">
        <header className="header">
          <img src="/trol-cafe.png" alt="Логотип кафе" className="cafe-logo" />
          <h1 className="cafe-title">Интернет-кафе</h1>
          <p className="cafe-subtitle">Меню управления</p>
        </header>
        <main>
          <DishList />
        </main>
      </div>
    </div>
  );
}

export default App;