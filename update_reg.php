<?php
session_start();

require_once 'php/connect.php';

// Проверяем статус администратора
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];

    $query_admin = "SELECT isAdmin FROM users WHERE ID_User = $user_id";
    $result_admin = mysqli_query($connect, $query_admin);

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row_admin = mysqli_fetch_assoc($result_admin);

        if ($row_admin['isAdmin'] == 1) {
            // Пользователь является администратором

            /*
             * Получаем ID продукта из адресной строки - /product.php?id=1
             */

            $type_id = $_GET['id'];

            /*
             * Делаем выборку строки с полученным ID выше
             */

            $user = mysqli_query($connect, "SELECT * FROM users WHERE ID_User = '$type_id'");

            /*
             * Преобразовывем полученные данные в нормальный массив
             * Используя функцию mysqli_fetch_assoc массив будет иметь ключи равные названиям столбцов в таблице
             */

            $user = mysqli_fetch_assoc($user);
        } else {
            // Пользователь не является администратором, перенаправляем на другую страницу
            header('Location: index.php');
            exit;
        }
    } else {
        // Пользователь не найден
        header('Location: index.php');
        exit;
    }

    // Освобождаем ресурсы
    mysqli_free_result($result_admin);
} else {
    // Пользователь не авторизован, перенаправляем на страницу авторизации
    header('Location: index.php');
    exit;
}
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Изменить Пользователя</title>
</head>
<body>
    <h3>Изменить Пользователя</h3>
    <form action="php/update_users.php" method="post">
        <input type="hidden" name="id" value="<?= $user['ID_User'] ?>">
        <p>Почта</p>
        <input type="mail" name="email" value="<?= $user['email'] ?>">
        <p>Имя</p>
        <input type="text" name="name" value="<?= $user['name'] ?>">
        <p>Фамилия</p>
        <input type="text" name="surname" value="<?= $user['surname'] ?>">
        <p>Пароль</p>
        <input type="password" name="password">
        <p>Админ</p>
        <input type="number" name="isAdmin" value="<?= $user['isAdmin'] ?>">
        <button type="submit">Изменить</button>
    </form>
</body>
</html>