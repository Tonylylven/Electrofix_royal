
<?php
// Подключение к БД
require_once('connect.php');

// Проверка заполнения reCAPTCHA
if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
    
    if (!$captcha) {
        // Если reCAPTCHA не заполнена, выводим сообщение об ошибке и останавливаем выполнение скрипта
        echo "<script>alert('Пожалуйста, заполните reCAPTCHA.'); window.location.href = '../index.php';</script>";
        exit;
    } else {
        // Если reCAPTCHA заполнена, обрабатываем форму
        
        // Получение данных из $_POST
        $name = $_POST['name'];
        $telephone = $_POST['telephone'];

        // Запрос на добавление данных
        mysqli_query($connect, "INSERT INTO users_2 (ID_User_2, telephone, name, status_call, curr_datetime) VALUES (NULL, '$telephone', '$name', '0', NOW())");

        // Возвращаемся на главную страницу
        header('Location: ../index.php');
        exit;
    }
}
?>