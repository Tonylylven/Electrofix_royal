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
$tel = $_POST['telephone'];
$status_call = $_POST['status_call'];
$date = $_POST['date'];



/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `users_2` SET `telephone` = '$tel', `status_call` = '$status_call',`curr_datetime` = '$date' WHERE `ID_User_2` = '$id'");

/*
 * Переадресация на главную страницу
 */
header('Location: ../admin.php');