<?php
session_start();
print_r($_POST);
require_once 'connect.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //проверяем, что поля не пустые
    if (!empty($email) && !empty($password)) {
        //проверяем, что такой пользователь есть в базе данных
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 1) {
            //получаем данные пользователя
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            // Проверяем значение email_confirmed
            if ($row['email_confirmed'] == 0) {
                // Email не подтвержден
                header('Location: ../index.php');
                exit();
            }
            //сравниваем хеши паролей
            if (md5($password) == $hashed_password) {
                //если пароли совпадают
                $_SESSION['user'] = $row['ID_User'];

                // Проверяем, является ли пользователь админом
                if ($row['isAdmin'] == 1) {
                    // Если пользователь админ, перенаправляем на страницу админки
                    header('Location: ../admin.php');
                } else {
                    // Если пользователь не админ, перенаправляем на страницу личного кабинета
                    header('Location: ../lk.php');
                }
                
                exit();
            } else {
                //если пароли не совпадают, выводим сообщение
                header('Location: ../index.php');
            }
        } else {
            //если такого пользователя нет, выводим сообщение
            header('Location: ../index.php');
        }
    } else {
        //если поля были пустыми, выводим сообщение
        header('Location: ../index.php');
    }
}
?>