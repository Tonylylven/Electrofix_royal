<?php
include 'access_admin.php';

//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$status_repair = $_POST['status_repair'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `status_repair` (`ID_Status_repair`, `status_repair`) VALUES (NULL, '$status_repair')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');