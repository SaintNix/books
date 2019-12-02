<?php

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Main';
        $controller_action = 'start';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $blocked = ['admin'];
        $auth = new Auth();

        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }
        if (!empty($routes[2])) {
            $controller_name .= "_" . $routes[2];
        } else {
            foreach ($blocked as $item) {
                if ($item == $routes[1]) {
                    if ($auth->isLogin()) {
                        $controller_name = 'admin';
                    } else {
                        $controller_name = 'auth';
                    }
                }
            }
        }

        //Роутинг Ajax запросов
        if (isset($_POST['ajax'])) {
            $data = $_POST;
            $controller_name = 'ajax';
            $controller_action = $_POST['action'];
        }

        // добавляем префиксы
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;

        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = strtolower($model_name) . '.php';
        $model_path = "models/$model_file";
        if (file_exists($model_path)) {
            include $model_path;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "controllers/$controller_file";

        if (file_exists($controller_path)) {
            include $controller_path;
            // создаем контроллер
            $controller = new $controller_name;
            // вызываем стандартрое действие контроллера
            $controller->$controller_action();
        } else {
            Route::page404();
        }
    }

    static function page404()
    {
        //отдаем заголовки 404
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        //подключаем класс 404
        include "controllers/controller_404.php";
        $controller = new Controller_404;
        //вызываем стандартрое действие контроллера
        $controller->start();
        die();
    }

}