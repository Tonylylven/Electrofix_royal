<?php
//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

include 'access_admin.php';

/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$status = $_POST['status'];
$engineer = $_POST['engineer'];
$user = $_POST['user'];
$device_type = $_POST['device_type'];
$start_date = $_POST['start_date'];
$completion_date = $_POST['completion_date'];
$component = $_POST['component'];
$warranty = $_POST['warranty'];
$manufacturer = $_POST['manufacturer'];
$model = $_POST['model'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `orders` (`ID_Order`, `ID_Status_repair`, `ID_Engineer`, `ID_User`, `ID_Device_type`, `start_date`, `completion_date`, `component`, `warranty`, `manufacturer`, `model`) VALUES (NULL, '$status', '$engineer', '$user', '$device_type', '$start_date', '$completion_date', '$component', '$warranty', '$manufacturer', '$model')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');