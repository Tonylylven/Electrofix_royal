<?php
require_once 'connect.php';
// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    // Получаем id и подтверждено ли Email
    if ($result = mysqli_query($connect, "SELECT `ID_User`, `email_confirmed` FROM `users` WHERE `hash`='" . $hash . "'")) {
        while( $row = mysqli_fetch_assoc($result) ) {
            // Проверяет получаем ли id и Email подтверждён ли 
            if ($row['email_confirmed'] == 0) {
                // Если всё верно, то делаем подтверждение
                mysqli_query($connect, "UPDATE `users` SET `email_confirmed`=1 WHERE `ID_User`=". $row['ID_User'] );
                echo "Email подтверждён";
            } else {
                echo "Что то пошло не так";
            }
        } 
    } else {
        echo "Что то пошло не так";
    }
} else {
    echo "Что то пошло не так";
}