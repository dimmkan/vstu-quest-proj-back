<?php
// включим отображение всех ошибок
error_reporting (E_ALL); 

phpinfo();
// подключаем конфиг
// include('config.php');

// // Соединяемся с БД
// $dbObject = new PDO('mysql:host=' . DB_HOST . ';port=3307;dbname=' . DB_NAME, DB_USER, DB_PASS);

// // подключаем ядро сайта
// include(SITE_PATH . DS . 'core' . DS . 'core.php');

// // Загружаем router
// $router = new Router($registry);
// // записываем данные в реестр
// $registry->set('router', $router);
// // задаем путь до папки контроллеров.
// $router->setPath(SITE_PATH . 'controllers');
// // запускаем маршрутизатор
// $router->start();
