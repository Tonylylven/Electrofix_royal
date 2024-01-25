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
    <link rel="stylesheet" href="scss/style.css">
    <title>ElectroFix</title>
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
            <!-- ПЕРВЫЙ ПОПАП -->
            <div class="popup-bg">
                <div class="popup">
                    <img class="close-popup" src="img/exit.png" alt="Выйти">
                    <form id="login-form" action="php/signin.php" method="post">
                        <h2 class="popup__title">Вход</h2>
                        <input type="email" name="email" placeholder="Почта" required>
                        <input type="password" name="password" placeholder="Пароль" required>
                        <input type="submit" value="Войти">
                        <a class="popup__link" href="#">Нет аккаунта? Зарегистрироваться</a>
                    </form>
                </div>
            </div>
            <!-- ВТОРОЙ ПОПАП -->
            <div class="popup-bg2" id="">
                <div class="popup">
                    <img class="close-popup" src="img/exit.png" alt="Выйти">
                    <form class="form" id="form2" action="php/signup.php" method="post">
                        <h2 class="popup__title">Регистрация</h2>
                        <input type="text" pattern="[А-Яа-яЁё]*" name="surname" placeholder="Фамилия" minlength="2" maxlength="20" required>
                        <input type="text" pattern="[А-Яа-яЁё]*" name="name" placeholder="Имя" minlength="2" maxlength="20" required>
                        <input type="password" name="password" placeholder="Пароль" minlength="6" required>
                        <input type="password" name="reppassword" placeholder="Повторите пароль" minlength="6" required>
                        <input type="email" name="email" placeholder="Почта" required>
                        <div class="g-recaptcha" data-sitekey="6LeGfugmAAAAABkoQUvauWrK46xDE-KX_ch_w31Q" data-callback="recaptchaCallback"></div>
                        <input type="submit" name="doGo" value="Зарегистрироваться">
                        <input type="hidden" name="recaptcha" id="recaptcha-response">
                        <a class="popup2__link" href="#">Уже есть аккаунт? Войти</a>
                    </form>
                </div>
            </div>
            
            <div class="hero__flex">
                <div class="hero__left">
                    <h1 class="hero__title">ElectroFix</h1>
                    <p class="hero__text">Сервисный центр электроники ElectroFix - это опытные профессионалы, которые готовы помочь вам в решении любых проблем с вашей техникой. Мы предлагаем широкий спектр услуг по ремонту и сервисному обслуживанию электроники таких брендов, как Samsung, LG, Sony, Apple и другие.</p>
                </div>
                <div class="hero_right">
                    <img class="right-photo" src="img/index/smartphone.png" alt="Телефон">
                </div>
            </div>
        </div>
    </section>

    <section class="problems">
        <div class="container">
            <!-- 3 ПОПАП -->
            <div class="popup-bg3">
                <div class="popup">
                    <img class="close-popup3" src="img/exit.png" alt="Выйти">
                    <form class="form" id="form3" action="php/add_user2.php" method="POST">
                        <h2 class="popup__title">Оставьте ваши данные</h2>
                        <input type="text" name="name" pattern="[А-Яа-яЁё]*" placeholder="Ваше имя" minlength="2" maxlength="20" required>
                        <input type="text" id="phone" name="telephone" placeholder="+7 (___) ___-__-__" pattern="\+7\(\d{3}\)\d{3}-\d{2}-\d{2}" required>
                        <div class="g-recaptcha" data-sitekey="6Le3iuomAAAAAHqW1ttnnpC4udydrBOotTzJJ3L5"></div>
                        <?php if(isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
                        <input type="submit" id="submitBtn" name="doGo2" value="Оставить заявку">
                    </form>
                </div>
            </div>
            <h2 class="problems__title">Какая у вас проблема?</h2>
            <div class="problems__row">
                <div class="problems__column problems-one">
                    <h3 class="problems__subtitle">Не включается</h3>
                    <ul class="problems__list">
                        <li class="problems__item">Ремонт цепи питания<span>&nbsp;от 1000₽</span></li>
                        <li class="problems__item">Ремонт материнской платы / пайка <br> <span>от 500 ₽</span></li>
                        <li class="problems__item">Замена HDD / SSD <span>от 250 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>

                <div class="problems__column problems-two">
                    <h3 class="problems__subtitle">Не заряжается</h3>
                    <ul class="problems__list">
                        <li class="problems__item">Замена аккумулятора с калибровкой <br> <span>от 300 ₽</span></li>
                        <li class="problems__item">Ремонт цепи питания <span>от 1000 ₽</span></li>
                        <li class="problems__item">Ремонт разъёма питания <span>от 320 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>

                <div class="problems__column problems-three">
                    <h3 class="problems__subtitle">Греется и выключается</h3>
                    <ul class="problems__list">
                        <li class="problems__item">Чистка <span>от 350 ₽</span></li>
                        <li class="problems__item">Ремонт системы охлаждения <br> <span>от 250 ₽</span></li>
                        <li class="problems__item">Замена кулера <span>от 250 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>
            </div>
            
            <div class="problems__row row-two">
                <div class="problems__column problems-two-one">
                    <h3 class="problems__subtitle">Нет изображения</h3>
                    <ul class="problems__list">
                        <li class="problems__item">Замена матрицы <span>от 300 ₽</span></li>
                        <li class="problems__item">Замена шлейфа <span>от 500 ₽</span></li>
                        <li class="problems__item">Замена лампы подсветки <span>от 500 ₽</span></li>
                        <li class="problems__item">Замена видеокарты <span>от 400 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>

                <div class="problems__column problems-two-two">
                    <h3 class="problems__subtitle">Шумит</h3>
                    <ul class="problems__list list__two">
                        <li class="problems__item">Чистка обычная без разбора <span>от 350 ₽</span></li>
                        <li class="problems__item">Чистка полная с разбором <span>от 780 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>

                <div class="problems__column problems-two-three">
                    <h3 class="problems__subtitle">Залитие</h3>
                    <ul class="problems__list">
                        <li class="problems__item">Чистка устройства после залития <br> <span>от 350 ₽</span></li>
                        <li class="problems__item">Ремонт материнской платы / пайка <br> <span>от 500 ₽</span></li>
                    </ul>
                    <a href="#" class="problems__button">Заказать ремонт</a>
                </div>
            </div>
        </div>
    </section>

    <section class="adventages">
        <div class="container">
            <div class="adventages__row">
                <div class="adventages__column">
                    <img src="img/index/moscow.png" alt="Крупнейшая сеть">
                    <p class="adventages__text">Крупнейшая сеть сервисных <br> центров в Москве</p>
                </div>

                <div class="adventages__column column-two">
                    <img src="img/index/time.png" alt="Выездной ремонт за 1 час">
                    <p class="adventages__text">Выездной ремонт за 1 час <br> в любую точку Москвы</p>
                </div>

                <div class="adventages__column column-three">
                    <img src="img/index/details.png" alt="Детали">
                    <p class="adventages__text">Детали оригинального <br> класса с гарантией до 1 года</p>
                </div>
            </div>
        </div>
    </section>

    <section class="reviews">
        <div class="container">
            <h2 class="reviews__title">Что говорят наши клиенты?</h2>
            <div class="reviews__column">
                <div class="reviews__item">
                    <div class="reviews__item__left">
                        <img src="img/index/1.png" alt="">
                    </div>
                    <div class="reviews__item__right">
                        <div class="reviews__item__upper">
                            <h3 class="reviews__name">Елена, 24</h3>
                            <ul class="reviews__scores">
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                            </ul>
                        </div>
                        <div class="reviews__item__lower">
                            <p class="reviews__text">“Сервисный центр Electrofix - быстрый, надежный и профессиональный ремонт <br> электроники. Спасибо за качественную работу!”</p>
                        </div>
                    </div>
                </div>

                <div class="reviews__item">
                    <div class="reviews__item__left">
                        <img src="img/index/2.png" alt="">
                    </div>
                    <div class="reviews__item__right">
                        <div class="reviews__item__upper">
                            <h3 class="reviews__name">Влад, 22</h3>
                            <ul class="reviews__scores">
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                            </ul>
                        </div>
                        <div class="reviews__item__lower">
                            <p class="reviews__text">“Мой опыт работы с сервисным центром Electrofix оцениваю на 4 звезды. Они сделали <br> быстрый и качественный ремонт моего смартфона, но я думаю, что цены немного <br> завышены. ”</p>
                        </div>
                    </div>
                </div>

                <div class="reviews__item">
                    <div class="reviews__item__left">
                        <img src="img/index/3.png" alt="">
                    </div>
                    <div class="reviews__item__right">
                        <div class="reviews__item__upper">
                            <h3 class="reviews__name">Анна, 20</h3>
                            <ul class="reviews__scores">
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                                <li class="reviews__scores__item"><img src="img/index/star.png" alt=""></li>
                            </ul>
                        </div>
                        <div class="reviews__item__lower">
                            <p class="reviews__text">“Я бы оценила работу сервисного центра Electrofix на 3 звезды. Они выполнили ремонт <br> моего телефона, но это заняло больше времени, чем они обещали. Кроме того, <br> стоимость ремонта оказалась немного выше, чем у других сервисов. Однако, качество <br> работы было на достаточно хорошем уровне.”</p>
                        </div>
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
<script src="js/add.js"></script>
</body>
</html>