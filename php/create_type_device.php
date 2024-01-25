<?php
include 'access_admin.php';
//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$type_device = $_POST['type_device'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `device_type` (`ID_Device_type`, `type_device`) VALUES (NULL, '$type_device')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');