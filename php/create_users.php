<?php
include 'access_admin.php';
//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$email = $_POST['email'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$password = md5($_POST['password']);
$isAdmin = $_POST['isAdmin'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `users` (`ID_User`, `email`, `name`, `surname`, `password`, `isAdmin`) VALUES (NULL, '$email', '$name', '$surname', '$password', '$isAdmin')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');