import React, { useState, useEffect } from 'react';

const DishForm = ({ 
  initialData, 
  onSubmit, 
  onCancel, 
  buttonText
}) => {
  const [formData, setFormData] = useState({
    name: '',
    description: '',
    price: '',
    category: '',
    quantity: 1
  });

  // Заполнение формы данными при редактировании
  useEffect(() => {
    if (initialData) {
      setFormData({
        name: initialData.name || '',
        description: initialData.description || '',
        price: initialData.price || '',
        category: initialData.category || '',
        quantity: initialData.quantity || 0
      });
    }
  }, [initialData]);

  // Обработка изменений в полях формы
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  // Обработка отправки формы без перезагрузки браузера
  const handleSubmit = (e) => {
    e.preventDefault();
    
    if (!formData.name.trim() || !formData.price || !formData.category.trim()) {
      alert('Пожалуйста, заполните все обязательные поля');
      return;
    }
    if (formData.price <= 0) {
      alert('Цена должна быть больше 0');
      return;
    }

    // Цена должна быть флотом а не строкой
    const dishData = {
      ...formData,
      price: parseFloat(formData.price)
    };
    onSubmit(dishData);

    // Сброс формы после отправки (только при создании)
    if (!initialData) {
      setFormData({
        name: '',
        description: '',
        price: '',
        category: ''
      });
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <div className="form-grid">
        <div className="form-group">
          <label className="form-label" htmlFor="name">
            Название блюда
          </label>
          <input
            type="text"
            id="name"
            name="name"
            className="form-input"
            value={formData.name}
            onChange={handleChange}
            placeholder="Например: Кофе Латте"
            required
          />
        </div>

        <div className="form-group">
          <label className="form-label" htmlFor="price">
            Цена (₽)
          </label>
          <input
            type="number"
            id="price"
            name="price"
            className="form-input"
            value={formData.price}
            onChange={handleChange}
            placeholder="Например: 150"
            min="0.01"
            step="0.01"
            required
          />
        </div>

        <div className="form-group">
          <label className="form-label" htmlFor="category">
            Категория
          </label>
          <select
            id="category"
            name="category"
            className="form-input"
            value={formData.category}
            onChange={handleChange}
            required
          >
            <option value="">Выберите категорию</option>
            <option value="Напитки">Напитки</option>
            <option value="Закуски">Закуски</option>
            <option value="Основные блюда">Основные блюда</option>
            <option value="Десерты">Десерты</option>
            <option value="Выпечка">Выпечка</option>
            <option value="Салаты">Салаты</option>
          </select>
        </div>

        <div className="form-group full-width">
          <label className="form-label" htmlFor="description">
            Описание блюда
          </label>
          <textarea
            id="description"
            name="description"
            className="form-textarea"
            value={formData.description}
            onChange={handleChange}
            placeholder="Опишите состав и особенности блюда..."
            rows="4"
          />
        </div>
      </div>

      <div className="form-group">
          <label className="form-label" htmlFor="quantity">
            Количество
          </label>
          <input
            type="number"
            id="quantity"
            name="quantity"
            className="form-input"
            value={formData.quantity}
            onChange={handleChange}
            placeholder="0"
            min="0"
          />
        </div>

      <div className="form-actions">
        <button type="submit" className="btn btn-save">
          {buttonText}
        </button>
        
        {onCancel && (
          <button type="button" className="btn btn-cancel" onClick={onCancel}>
            Отмена
          </button>
        )}
      </div>
    </form>
  );
};

export default DishForm;