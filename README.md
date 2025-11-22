<<<<<<< HEAD
# Cafe Backend API

REST API для управления блюдами в кафе с веб-интерфейсом CRUD.

## Установка

1. Клонируйте репозиторий
2. Установите зависимости: `composer install`
3. Скопируйте `.env.example` в `.env` и настройте базу данных
4. Сгенерируйте ключ: `php artisan key:generate`
5. Запустите миграции: `php artisan migrate`
6. Запустите сиды: `php artisan db:seed`

## API Endpoints

- `GET /api/items` - список всех блюд
- `GET /api/items/{id}` - получить блюдо по ID
- `POST /api/items` - создать новое блюдо
- `PUT /api/items/{id}` - обновить блюдо
- `DELETE /api/items/{id}` - удалить блюдо

## Веб-интерфейс

Доступен по адресу: `/crud.php`

## Технологии

- Laravel 10
- MySQL
- REST API
=======
# cafe-crud-laravel
RIP
>>>>>>> 61b7b629931adc385e5614330b7a0830c55a3bec
