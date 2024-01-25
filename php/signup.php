<?php
session_start();
require_once 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';

if (isset($_REQUEST['doGo'])) {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $reppassword = $_POST['reppassword'];
    $email = $_POST['email'];

    // Проверка существования пользователя с таким же email
    $check_email = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        // Пользователь с таким email уже существует
        echo json_encode(array('success' => false, 'error' => 'user_exists'));
        exit();
    }

    // Проверка соответствия паролей
    if ($password != $reppassword) {
        // Пароли не совпадают
        echo json_encode(array('success' => false, 'error' => 'password_mismatch'));
        exit();
    }

    // Проверка заполнения рекапчи
    if (empty($_POST['recaptcha'])) {
        // Рекапча не заполнена или не отправлена
        echo json_encode(array('success' => false, 'error' => 'empty_captcha'));
        exit();
    }

    // Проверка рекапчи
    $recaptcha = $_POST['recaptcha'];
    $secretKey = "6LeGfugmAAAAAPeye0LzB9CoAYA7b5usxQ5yb7q3";
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($recaptcha));
    $responseData = json_decode($response);

    if (!$responseData || !$responseData->success) {
        // Ошибка рекапчи
        echo json_encode(array('success' => false, 'error' => 'captcha_failed'));
        exit();
    }

    // Хеширование пароля
    $password = md5($password);

    // Хешируем хеш, который состоит из email и времени
    $hash = md5($email . time());

    mysqli_query($connect, "INSERT INTO users (surname, name, password, email, hash, isAdmin, email_confirmed) VALUES ('$surname', '$name', '$password', '$email', '$hash', '0', '0')");
    // Отправка письма с подтверждением
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'electrofix.info.register@gmail.com';
        $mail->Password = 'uugbpnphbhfzpalu';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('electrofix.info.register@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Подтвердите Email';
        $mail->Body = '
            <html>
            <head>
            <title>Подтвердите Email</title>
            </head>
            <body>
            <p>Привет ' . $name .'! Чтобы подтвердить Email, перейдите по <a href="http://user8700.royal-hosting.ru/php/confirmed.php?hash=' . $hash . '">ссылке</a></p>
            </body>
            </html>
        ';

        $mail->send();
        // Если письмо успешно отправлено
        echo json_encode(array('success' => true));
        exit();
    } catch (Exception $e) {
        // Если письмо не удалось отправить
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }
}
?>