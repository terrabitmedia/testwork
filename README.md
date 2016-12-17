Тестовое задание
============================

Было дано задание. Список задач, как и название организации, была просьба не разглашать.

Затраченное время примерно: 4-5 дней. Делал урывками, когда было время. В рабочее время было бы быстрей.

Ссылка на резюме: 
https://stavropol.hh.ru/resume/3625ab14ff02f7de2c0039ed1f72364e4a484f

Установка через composer
-------------------

    composer global require "fxp/composer-asset-plugin:^1.2.0"
    composer create-project --prefer-dist --stability=dev terrabitmedia/testwork application

Процесс установки
-------------------
    
    Создайте бд для проекта любым удобным способом
    Отредактируйте параметры подключения к БД в файле <your project on server>/config/db.php
    php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
    php yii migrate/up --migrationPath=@yii/rbac/migrations
    php yii migrate/up --migrationPath=@app/modules/users/migrations
    php yii migrate/up --migrationPath=@app/modules/news/migrations
    php yii migrate/up --migrationPath=@app/modules/events/migrations
    php yii install/run


Создать задание в кроне на каждую минуту:
-------------------

    php <your project on server>/yii events/processes/messages

Для проведения тестов по проекту вам нужно:
-------------------

    Создайте тестовую бд для проекта любым удобным способом
    Отредактируйте параметры подключения к БД в файле <your project on server>/config/test_db.php
    cd <your project on server>/tests/bin
    php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
    php yii migrate/up --migrationPath=@yii/rbac/migrations
    php yii migrate/up --migrationPath=@app/modules/users/migrations
    php yii migrate/up --migrationPath=@app/modules/news/migrations
    php yii migrate/up --migrationPath=@app/modules/events/migrations
    php yii install/run
    
    Запустите тесты codecept run


Логины и пароли на сайте:
------------

Admin: Логин: admin Пароль: 123456

Manager: Логин: manager Пароль: 123456

User: Логин: user Пароль: 123456

Обшая информация по проекту
------------

Проект разделен на два модуля NEWS и EVENTS. В проекте были использованы два сторонних модуля yii2-user и yii2-rbac. 
Модуль yii2-user был переопределен и дополнен под нужды проекта. 
В модуле NEWS - добавление, удаление, обновление новостей. 
В модуле EVENTS - добавление, обновление, удаление прослушивателей событий есть возможность наложить на слушателя правила и пользователя. Добавление, удаление провайдеров.

Добавление событий
------------

Из выпадающего списка выберете событие и класс, на который нужно 
наложить событие. Создайте обработчик сообщений 
(Назовите его, выберете класс обработчика и заполните шаблоны, 
если нужно добавьте ключи для замены.) Добавьте правило 
(Правил можно добавлять несколько) и группу пользователей или себя,
 если нужно (Пользователей можно добавлять несколько).

Список событий /index.php?r=events%2Fadmin%2Findex
Создание событий /index.php?r=events%2Fadmin%2Fcreate

Добавление провайдеров
------------

Для создания провайдера вы должны описать этот провайдер 
а потом добавить его в проект через форму добавления если нужно добавить настройки через поле data.

Список провайдеров /index.php?r=events%2Fproviders%2Findex
Создание провайдера /index.php?r=events%2Fproviders%2Fcreate

Добавление новостей
------------

Список новостей /index.php?r=news%2Fnews%2Findex
Создание новостей /index.php?r=news%2Fnews%2Fcreate

Работа с пользователями и аккаунт
------------

Администрирование пользователей /index.php?r=user%2Fadmin%2Findex
Включать и отключать провайдеры /index.php?r=events%2Fsettings%2Fproviders

Моментально отослать сообщение
------------

Моментально отослать сообщения пользователям /index.php?r=events%2Fmessages%2Fsend-messages