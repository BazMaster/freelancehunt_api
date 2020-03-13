[![GitHub CEO/SMI](https://img.shields.io/badge/developer-BazMaster-blue.svg)](https://github.com/BazMaster)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

---

Ссылка на репозиторий: https://github.com/BazMaster/freelancehunt_api

Ссылка на демо: https://freelancehunt_api.bazmaster.ru/

-----


## Цель проекта:

Используя Freelancehunt API, получить список всех открытых проектов и сохранить его в базу данных. 
На основании полученных данных отобразить для пользователя страницу, на которой будет отображено:

1. Таблица открытых проектов в категориях *Веб-программирование*, *PHP* и *Базы данных*: 
   - Название проекта со ссылкой на него, бюджет, имя и логин заказчика.
   - Постраничный вывод — 10 проектов на страницу.
2. Таблица со статистикой всех открытых проектов по навыкам: 
   - Навык ➡ количество открытых проектов.
3. График с распределением всех проектов по бюджету: 
   - Pie chart
   - Группы: до 500 грн, 500-1000 грн, 1000-5000 грн, 5000-10000 грн, более 10000 грн. 

### 🛠 Детали реализации

* Для бекенда использованы готовые библиотеки packagist, но не полный фреймворк из коробки
* Нужные данные из API сохраняются в БД. 
* Для конвертации валюты использован [API Приватбанк](https://api.privatbank.ua/#p24/exchange).
* База данных MySQL.    
* ORM библиотека Doctrine.    
* Работа с сервером, [встроенным в PHP](https://www.php.net/manual/en/features.commandline.webserver.php).
* Тесты для бекенда, тесты для фронтенда 🏅
* На задачу было потрачено более 4-х часов

## Установка

Копирование репозитория в папку:
```
git clone https://github.com/BazMaster/freelancehunt_api.git .
```

Установка библиотек:
```
composer install
```

Настройка доступа к БД в файле:
```
app/config.php
```

Создание таблицы в БД
```
vendor/bin/doctrine orm:schema-tool:create
```

Импорт проектов в БД по API через CRON скрипт:
```
php -f app/cron/import.php
```

Запуск PHP-сервера:
```
cd public/
php -S localhost:8000
```



# VUE

Установка Vue CLI
```
npm install -g @vue/cli
```

Запуск
```
npm run dev
npm run build
```
