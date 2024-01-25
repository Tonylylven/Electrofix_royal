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
$email = $_POST['email'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$pass = md5($_POST['password']);
$isAdmin = $_POST['isAdmin'];



/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `users` SET `email` = '$email', `name` = '$name', `surname` = '$surname', `password` = '$pass', `isAdmin` = '$isAdmin' WHERE `ID_User` = '$id'");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');