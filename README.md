# PHP Yii

## Установка
1. Склонируйте проект
2. Скопируйте `.env.example` в `.env`

    ```$ cp .env.example .env```
3. Затем установите нужные значения переменных среды
4. Зайдите в корневую папку проекта

    ```$ cd public/```
5. Запустите

    ```$ docker-compose up -d```

4. Создайте свой файл `.env.local` и укажите локальные переменные среды окружения

    ```$ echo APP_ENV=production >> .env.local```

    При `APP_ENV=development` ошибки будут показываться со **стектрейсом**


### Установка зависимостей
```bash
$ docker exec -ti <app_container_name> //bin/bash
$ composer install
```


### Миграции
```bash
$ docker exec -ti <app_container_name> //bin/bash
$ cd public/
$ ./protected/yiic migrate
```

### Чтобы убрать предупреждение
```Xdebug: [Step Debug] Could not connect to debugging client. Tried: host.docker.internal:9003 (through xdebug.client_host/xdebug.client_port).```
### можно указать
```$ php -d xdebug.log_level=0 ./protected/yiic migrate```
### или экспортировать переменную для текущей сессии терминала
```bash
export XDEBUG_CONFIG="log_level=0"
php your_script.php
```
### Запустите проект http://localhost:8090/
Порт из переменной `.env` NGINX_PORT
