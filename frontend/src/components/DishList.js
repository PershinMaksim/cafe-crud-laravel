import React, { useState, useEffect } from 'react';
import Dish from './Dish';
import DishForm from './DishForm';
import api from '../api/api';

const DishList = () => {
  const [dishes, setDishes] = useState([]);
  const [editingDishId, setEditingDishId] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Сначала тестируем соединение, потом загружаем данные
  useEffect(() => {
    const initializeApp = async () => {
      try {
        setLoading(true);
        
        // Тестируем соединение с API
        console.log('🔄 Testing API connection...');
        await api.testConnection();
        console.log('✅ API connection successful');
        
        // Загружаем блюда
        console.log('🔄 Loading dishes...');
        const data = await api.getDishes();
        console.log('✅ Dishes loaded:', data);
        setDishes(data);
        
        setError(null);
      } catch (err) {
        console.error('❌ Initialization failed:', err);
        setError(`Ошибка: ${err.message}`);
        
        // Показываем моковые данные при ошибке
        const mockDishes = [
          {
            id: 1,
            name: "Кофе Американо",
            description: "Классический черный кофе",
            price: 120,
            category: "Напитки"
          }
        ];
        setDishes(mockDishes);
      } finally {
        setLoading(false);
      }
    };

    initializeApp();
  }, []);

  // Остальные функции без изменений
  const addDish = async (dishData) => {
    try {
      console.log('Adding dish:', dishData);
      const newDish = await api.createDish(dishData);
      console.log('Dish added successfully:', newDish);
      setDishes([...dishes, newDish]);
      setError(null);
    } catch (err) {
      console.error('Error adding dish:', err);
      setError(`Ошибка добавления блюда: ${err.message}`);
    }
  };

  const updateDish = async (id, updatedDish) => {
    try {
      console.log('Updating dish:', id, updatedDish);
      const result = await api.updateDish(id, updatedDish);
      console.log('Dish updated successfully:', result);
      setDishes(dishes.map(dish => 
        dish.id === id ? result : dish
      ));
      setEditingDishId(null);
      setError(null);
    } catch (err) {
      console.error('Error updating dish:', err);
      setError(`Ошибка обновления блюда: ${err.message}`);
    }
  };

  const deleteDish = async (id) => {
    if (window.confirm('Вы уверены, что хотите удалить это блюдо?')) {
      try {
        console.log('Deleting dish:', id);
        await api.deleteDish(id);
        console.log('Dish deleted successfully');
        setDishes(dishes.filter(dish => dish.id !== id));
        setError(null);
      } catch (err) {
        console.error('Error deleting dish:', err);
        setError(`Ошибка удаления блюда: ${err.message}`);
      }
    }
  };

  const startEditing = (dish) => {
    setEditingDishId(dish.id);
  };

  const cancelEditing = () => {
    setEditingDishId(null);
  };

  if (loading) {
    return (
      <div className="loading">
        <h3>Загрузка...</h3>
        <p>Проверяем соединение с сервером</p>
      </div>
    );
  }

  return (
    <div className="dishes-container">
      {error && (
        <div className="error-message">
          <strong>Внимание:</strong> {error}
          <br />
          <small>Работаем в оффлайн-режиме. Данные не сохраняются на сервере.</small>
          <button onClick={() => setError(null)}>×</button>
        </div>
      )}

      {/* Форма добавления нового блюда */}
      <div className="form-container">
        <h2 className="form-title">Добавить новое блюдо в меню</h2>
        <DishForm onSubmit={addDish} buttonText="Добавить блюдо"/>
      </div>

      {/* Список блюд */}
      <div>
        <h2 style={{ marginBottom: '1.5rem', color: '#333' }}>
          Меню кафе ({dishes.length} блюд)
        </h2>
        
        {dishes.length === 0 ? (
          <div className="empty-state">
            <h3>Меню пусто</h3>
            <p>Добавьте первое блюдо в меню вашего кафе</p>
          </div>
        ) : (
          dishes.map(dish => (
            <Dish
              key={dish.id}
              dish={dish}
              onEdit={startEditing}
              onDelete={deleteDish}
              onUpdate={updateDish}
              onCancelEdit={cancelEditing}
              isEditing={editingDishId === dish.id}
            />
          ))
        )}
      </div>
    </div>
  );
};

export default DishList;