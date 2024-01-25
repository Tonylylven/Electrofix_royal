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
$status_repair = $_POST['status_repair'];


/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `status_repair` SET `status_repair` = '$status_repair' WHERE `ID_Status_repair` = '$id'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');