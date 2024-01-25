<?php

//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */
include 'access_admin.php';

/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$name = $_POST['name'];
$surname = $_POST['surname'];

/*
 * Делаем запрос на добавление новой строки в таблицу products
 */

mysqli_query($connect,"INSERT INTO `engineers` (`ID_Engineer`, `name`, `surname`) VALUES (NULL, '$name', '$surname')");

/*
 * Переадресация на главную страницу
 */

header('Location: ../admin.php');