<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверяем, что запрос не пустой
    if (!empty($_POST)) {
        // Подключение к базе данных
        require_once('connect.php');

        // Получаем информацию о пользователе
        $user_id = $_SESSION['user'];

        $query = "SELECT isAdmin FROM users WHERE ID_User = $user_id";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if ($row['isAdmin'] == 1) {
                // Пользователь является администратором

                // Добавьте свой код для работы с базой данных

                // Выводим сообщение об успешной обработке запроса
                echo "Запрос успешно обработан!";
            } else {
                // Пользователь не является администратором
                header('Location: ../index.php');
                exit;
            }
        } else {
            // Пользователь не найден
            header('Location: ../index.php');
            exit;
        }

        // Освобождаем ресурсы
        mysqli_free_result($result);
    } else {
        // Выводим сообщение об ошибке, если запрос пустой
        header('Location: ../index.php');
        exit;
    }
} else {
    // Выводим сообщение об ошибке для неправильного метода запроса
    header('Location: ../index.php');
    exit;
}
?>