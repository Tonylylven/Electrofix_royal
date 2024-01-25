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
$name = $_POST['name'];
$surname = $_POST['surname'];


/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `engineers` SET `name` = '$name', `surname` = '$surname' WHERE `ID_Engineer` = '$id'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');
