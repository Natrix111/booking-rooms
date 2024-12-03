# Docker

# Инструкция

1. Склонируйте репозиторий:

```bash
   git clone https://github.com/Natrix111/booking-rooms.git
```

2. Перейдите в директорию проекта:

```bash
    cd docker
```

3. Создайте файл .env на основе .env.example

4. Для запуска окружения введите команды:
```bash
      docker-compose up --build
      docker-compose exec app composer install
```

5. Для запуска миграция и заполнения базы данных тестовыми данными введите команды:
```bash
      docker-compose exec app php artisan migrate
      docker-compose exec app php artisan db:seed
```