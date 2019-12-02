<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
session_start();
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/auth.php';
require_once 'config/config.php';
Route::start(); // запуск роутера