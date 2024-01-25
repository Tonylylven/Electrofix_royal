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

            $device = mysqli_query($connect, "SELECT * FROM device_type WHERE ID_Device_type = '$type_id'");

            /*
             * Преобразовывем полученные данные в нормальный массив
             * Используя функцию mysqli_fetch_assoc массив будет иметь ключи равные названиям столбцов в таблице
             */

            $device = mysqli_fetch_assoc($device);
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
    <title>Изменить тип девайса</title>
</head>
<body>
    <h3>Изменить тип девайса</h3>
    <form action="php/update_type_device.php" method="post">
        <input type="hidden" name="id" value="<?= $device['ID_Device_type'] ?>">
        <p>Тип девайса</p>
        <input type="text" name="type_device" value="<?= $device['type_device'] ?>">
        <button type="submit">Изменить</button>
    </form>
</body>
</html>