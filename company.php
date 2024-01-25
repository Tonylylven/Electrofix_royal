<?php
session_start();
require_once 'php/connect.php';
// проверяем, авторизован ли пользователь
$is_logged_in = false; // по умолчанию пользователь не авторизован
$is_admin = false; // по умолчанию пользователь не админ

if (isset($_SESSION['user'])) {
    // пользователь авторизован
    $is_logged_in = true;
    
    // Получение информации о пользователе из базы данных
    $sql = "SELECT isAdmin FROM users WHERE ID_User = ".$_SESSION['user'];
    $result = mysqli_query($connect, $sql);

    if($result && mysqli_num_rows($result) == 1) {
        // получаем данные пользователя
        $row = mysqli_fetch_assoc($result);

        // Проверка значения столбца isAdmin
        if($row['isAdmin'] == 1) {
            $is_admin = true; // Пользователь является администратором
        }
    }
}
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/reset.css">
    <link rel="stylesheet" href="scss/about.css">
    <title>О компании</title>
</head>
<body>
<header class="header">
    <div class="header__container">
        <button class="header__burger-btn" id="burger">
            <span></span><span></span><span></span>
        </button>
        <nav class="header__nav">
            <ul class="header__links">
                <li>
                    <?php
                    if ($is_logged_in) {
                    // Проверяем, является ли пользователь админом
                    if ($is_admin) {
                    echo '<a href="admin.php"><img src="img/index/Person.png" alt="Админка"></a>';
                    } else {
                    echo '<a href="lk.php"><img src="img/index/Person.png" alt="Личный кабинет"></a>';
                    }
                    } else {
                    echo '<a class="open-popup" href="#"><img src="img/index/Person.png" alt="Личный кабинет"></a>';
                    }
                    ?>
                </li>
                <li><a href="company.php">О компании</a></li>
                <li><a href="services.php">Услуги</a></li>
                <li><a href="index.php"><img src="img/index/logo.png" alt="Главная страница"></a></li>
                <li><a href="work.php">Как мы работаем?</a></li>
                <li><a class="header__button" href="check.php">Проверить ремонт</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="main">
    <section class="hero">
        <div class="container">
            <div class="popup-bg">
                <div class="popup">
                    <img class="close-popup" src="img/exit.png" alt="Выйти">
                    <form action="php/signin.php" method="post">
                        <h2 class="popup__title">Вход</h2>
                        <input type="email" name="email" placeholder="Почта">
                        <input type="password" name="password" placeholder="Пароль">
                        <input value="Войти" type="submit">
                        <a class="popup__link" href="#">Нет аккаунта? Зарегистрироваться</a>
                    </form>
                </div>
            </div>
        <!-- ВТОРОЙ ПОПАП -->
            <div class="popup-bg2" id="">
                <div class="popup">
                    <img class="close-popup" src="img/exit.png" alt="Выйти">
                    <form action="php/signup.php" method="post">
                        <h2 class="popup__title">Регистрация</h2>
                        <input type="text" pattern="[А-Яа-яЁё]*" name="surname" placeholder="Фамилия" minlength="2" maxlength="20" required>
                        <input type="text" pattern="[А-Яа-яЁё]*" name="name" placeholder="Имя" minlength="2" maxlength="20" required>
                        <input type="password" name="password" placeholder="Пароль" minlength="6" required>
                        <input type="password" name="reppassword" placeholder="Повторите пароль" minlength="6" required>
                        <input type="email" name="email" placeholder="Почта" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                        <div class="g-recaptcha" data-sitekey="6LeGfugmAAAAABkoQUvauWrK46xDE-KX_ch_w31Q" data-callback="recaptchaCallback"></div>
                        <input type="submit" name="doGo" value="Зарегистрироваться">
                        <input type="hidden" name="recaptcha" id="recaptcha-response">
                        <a class="popup2__link" href="#">Уже есть аккаунт? Войти</a>
                    </form>
                </div>
            </div>
            <div class="hero__row">
                <h1 class="hero__title">Почему именно мы?</h1>
                <div class="hero__right">
                    <div class="hero__item">
                        <img src="img/company/mark.png" alt="">
                        <p>Каждый из нас регулярно сталкивается с проблемой внезапного выхода из строя техники. Главная сложность в такой ситуации - быстро найти хороший сервисный центр для ремонта.</p>
                    </div>

                    <div class="hero__item">
                        <img src="img/company/mark.png" alt="">
                        <p>Ежедневно к нам обращаются более 150 клиентов, ни один из которых не ушел недовольным качеством оказываемых услуг. Мы очень дорожим собственной репутацией, поэтому выполняем все ремонтные работы на совесть.</p>
                    </div>

                    <div class="hero__item">
                        <img src="img/company/mark.png" alt="">
                        <p>Для быстрого и качественного сервисного обслуживания в Москве, мы сотрудничаем с партнерским сервисным центром. Если вам нужно выполнить диагностику или ремонт оборудования, обращайтесь.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="partners">
        <div class="container">
            <h2 class="partners__title">Наши партнеры</h2>
            <div class="partners__wrapper">
                <div class="partners__row">
                    <img src="img/index/apple.png" alt="" class="partners__item">
                    <img src="img/index/asus.png" alt="" class="partners__item">
                    <img src="img/index/lg.png" alt="" class="partners__item">
                </div>
                <div class="partners__row row-two">
                    <img src="img/index/philips.png" alt="" class="partners__item">
                    <img src="img/index/samsung.png" alt="" class="partners__item">
                </div>
            </div>
        </div>
    </section>
    <section class="team">
        <div class="container">
            <h2 class="team__title">Команда</h2>
            <div class="team__row">
                <div class="team__column__first">
                    <img src="img/company/team1.png" alt="Команда">
                </div>
                <div class="team__column__second">
                    <img src="img/company/team2.png" alt="Команда">
                    <img src="img/company/team3.png" alt="Команда">
                </div>
                <div class="team__column__third">
                    <img src="img/company/team4.png" alt="Команда">
                </div>
            </div>
        </div>
    </section>
    <section class="sertification">
        <div class="container">
            <h2 class="sertification__title">Сертификация</h2>
            <div class="sertification__row">
                <img src="img/company/sertificat1.png" alt="Сертификат">
                <img src="img/company/sertificat2.png" alt="Сертификат">
            </div>
        </div>
    </section>
    <section class="contacts">
        <div class="container">
            <h2 class="contacts__title">Наши контакты</h2>
            <div class="contacts__row">
                <img src="img/company/logo.png" alt="ElectroFix">
                <p class="contacts__text">Москва, Каширское ш., д. 80, к. 1
                    Москва, ул. Пушкина, д.12, к.23
                    +7(999)999-99-99 <br>
                    Ежедневно с 6:00 до 23:00
                    info@electrofix.ru</p>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="container">
        <div class="footer__row">
            <div class="footer__column">
                <a class="footer__logo" href="index.php"><img src="img/index/logo1.png" alt="ElectroFix"></a>
            </div>
            
            <div class="footer__column">
                <h4>О компании</h4>
                <ul class="footer__list">
                    <li class="footer__item__list">Отзывы</li>
                    <li class="footer__item__list">Партнеры</li>
                    <li class="footer__item__list">Условия использования</li>
                </ul>
            </div>

            <div class="footer__column">
                <h4>Контакты</h4>
                <ul class="footer__list">
                    <li class="footer__item__list">Москва, Каширское ш., д. 80, к. 1</li>
                    <li class="footer__item__list">Москва, ул. Пушкина, д.12, к.23</li>
                    <li class="footer__item__list">+7(999)999-99-99</li>
                    <li class="footer__item__list">Ежедневно с 6:00 до 23:00</li>
                    <li class="footer__item__list">info@electrofix.ru</li>
                </ul>
            </div>
        </div>
        <p class="copyright">© 2023 Electrofix.ru</p>
    </div>
</footer>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/capcha.js"></script>
<script src="js/popup.js"></script>
</body>
</html>