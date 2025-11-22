const API_BASE_URL = process.env.REACT_APP_API_BASE_URL || 'http://localhost:8000/api';

class ApiService {
  constructor() {
    this.baseURL = API_BASE_URL;
  }

  async request(endpoint, options = {}) {
    const url = `${this.baseURL}${endpoint}`;
    
    console.log(`🔄 Making ${options.method || 'GET'} request to: ${url}`);
    
    try {
      const response = await fetch(url, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          ...options.headers,
        },
        ...options,
      });

      console.log(`📊 Response status: ${response.status}`);

      // Если ответ не OK, но есть тело ответа
      if (!response.ok) {
        let errorMessage = `HTTP error! status: ${response.status}`;
        
        try {
          const errorData = await response.json();
          errorMessage += `, message: ${JSON.stringify(errorData)}`;
        } catch {
          const errorText = await response.text();
          errorMessage += `, message: ${errorText}`;
        }
        
        throw new Error(errorMessage);
      }

      // Для DELETE запросов может не быть тела ответа
      if (response.status === 204) {
        return null;
      }

      const data = await response.json();
      console.log('✅ Response data:', data);
      return data;

    } catch (error) {
      console.error('❌ API request failed:', error);
      
      // Более детальная обработка ошибок
      if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
        throw new Error('Не удалось подключиться к серверу. Убедитесь, что бэкенд запущен на localhost:8000');
      }
      
      throw error;
    }
  }

  // Получить все блюда
  getDishes() {
    return this.request('/dishes');
  }

  // Создать блюдо
  createDish(dishData) {
    return this.request('/dishes', {
      method: 'POST',
      body: JSON.stringify(dishData),
    });
  }

  // Обновить блюдо
  updateDish(id, dishData) {
    return this.request(`/dishes/${id}`, {
      method: 'PUT',
      body: JSON.stringify(dishData),
    });
  }

  // Удалить блюдо
  deleteDish(id) {
    return this.request(`/dishes/${id}`, {
      method: 'DELETE',
    });
  }

  // Тестовый запрос для проверки соединения
  testConnection() {
    return this.request('/test');
  }
}

const api = new ApiService();
export default api;