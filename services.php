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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/reset.css">
    <link rel="stylesheet" href="scss/services.css">
    <title>Услуги и цены</title>
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
            <h1 class="hero__title">У нас самые дешевые цены</h1>
            <img src="img/services/phone.png" alt="Смартфон">
        </div>
    </div>
</section>
<section class="services">
    <div class="container">
        <h2 class="services__title">Услуги</h2>
        <div class="services__column">
            <div class="services__item">
                <h3 class="services__subtitle">Ноутбуки</h3>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
            </div>
            
            <div class="services__item">
                <h3 class="services__subtitle">Телефоны</h3>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
            </div>

            <div class="services__item">
                <h3 class="services__subtitle">Компьютеры</h3>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
                <div class="services__row">
                    <div class="services__column__item">
                        <p class="services__info">Диагностика</p>
                        <p class="services__cost">от 4000₽</p>
                    </div>
                    <img src="img/services/Line3.png" alt="">
                </div>
            </div>
        </div>
        <span class="services__extra">Ремонт по остальным устройствам уточняйте по телефону.</span>
    </div>
</section>
<section class="check">
    <div class="container">
        <h2 class="check__title">Проверить ремонт по ID заказа</h2>
        <input type="text" class="check__input" placeholder="Введите ID заказа">
        <div class="check__result"></div>
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
<script src="js/search.js"></script>
</body>
</html>