<?php
session_start();

require_once 'php/connect.php';

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];

    $query = "SELECT isAdmin FROM users WHERE ID_User = $user_id";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['isAdmin'] == 1) {
            // Пользователь является администратором

            /*
             * Получаем ID продукта из адресной строки - /product.php?id=1
             */

            $type_id = $_GET['id'];

            /*
             * Делаем выборку строки с полученным ID выше
             */

            $engineer = mysqli_query($connect, "SELECT * FROM engineers WHERE ID_Engineer = '$type_id'");

            /*
             * Преобразовывем полученные данные в нормальный массив
             * Используя функцию mysqli_fetch_assoc массив будет иметь ключи равные названиям столбцов в таблице
             */

            $engineer = mysqli_fetch_assoc($engineer);
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
    mysqli_free_result($result);
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
    <title>Изменить данные техника</title>
</head>
<body>
    <h3>Изменить данные техника</h3>
    <form action="php/update_engineers.php" method="post">
        <input type="hidden" name="id" value="<?= $engineer['ID_Engineer'] ?>">
        <p>Имя</p>
        <input type="text" name="name" value="<?= $engineer['name'] ?>">
        <p>Фамилия</p>
        <input type="text" name="surname" value="<?= $engineer['surname'] ?>">
        <button type="submit">Изменить</button>
    </form>
</body>
</html>