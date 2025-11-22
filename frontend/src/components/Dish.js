import React from 'react';
import DishForm from './DishForm';

const Dish = ({ 
  dish, 
  onEdit, 
  onDelete, 
  onUpdate, 
  onCancelEdit,
  isEditing
}) => {
  // Сохранение изменений
  const handleSave = (updatedDish) => {
    onUpdate(dish.id, updatedDish);
  };

  // Отмена редактирования
  const handleCancel = () => {
    onCancelEdit();
  };

  // Нежим редактирования
  if (isEditing) {
    return (
      <div className="dish-card">
        <DishForm
          initialData={dish}
          onSubmit={handleSave}
          onCancel={handleCancel}
          buttonText="Сохранить изменения"
        />
      </div>
    );
  }

  // Отображение
  return (
    <div className="dish-card">
      <div className="dish-header">
        <h3 className="dish-name">{dish.name}</h3>
        <div className="dish-price">{dish.price} ₽</div>
      </div>
      
      <div className="dish-category">{dish.category}</div>
      
      <p className="dish-description">{dish.description}</p>
      
      <div className="dish-actions">
        <button className="btn btn-edit" onClick={() => onEdit(dish)}>
          ✏️ Редактировать
        </button>
        <button className="btn btn-delete" onClick={() => onDelete(dish.id)}>
          🗑️ Удалить
        </button>
      </div>
    </div>
  );
};

export default Dish;