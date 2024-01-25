<?php
include 'access_admin.php';
//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$name = $_POST['name'];
$tel = $_POST['telephone'];
$status_call = $_POST['status_call'];
$date = $_POST['curr_date'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `users_2` (`ID_User_2`, `telephone`, `name`, `status_call`, `curr_datetime`) VALUES (NULL, '$tel', '$name', '$status_call', '$date')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');