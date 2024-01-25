<?php
include 'access_admin.php';

//Обновление информации о типе девайса

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$id = $_POST['id'];
$type_device = $_POST['type_device'];


/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `device_type` SET `type_device` = '$type_device' WHERE `ID_Device_type` = '$id'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');
