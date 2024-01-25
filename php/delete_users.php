<?php
session_start();
function isAdmin() {
    // Проверяем, авторизован ли пользователь как администратор
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user'];

        // Подключение к базе данных
        include('connect.php');

        $query = "SELECT isAdmin FROM users WHERE ID_User = $user_id";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['isAdmin'] == 1) {
                return true;
            }
        }
    }
    return false;
}
require_once 'connect.php';

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */


/*
 * Получаем ID продукта из адресной строки
 */

$id = $_GET['id'];

/*
 * Делаем запрос на удаление строки из таблицы products
 */
if (isAdmin()) {
    mysqli_query($connect, "DELETE FROM `users` WHERE `ID_User` = '$id'");
    header('Location: ../admin.php');
} else {
    // Пользователь не является администратором
    header('Location: ../index.php');
    exit;
}