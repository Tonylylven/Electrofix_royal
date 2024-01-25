<?php
// Проверяем, есть ли у пользователя сессия с его идентификатором
session_start();
require_once 'php/connect.php';
if (!isset($_SESSION['user'])) {
    // Идентификатор пользователя не найден, перенаправляем на страницу входа
    header('Location: index.php');
    exit;
}
$user = $_SESSION['user'];
$result = $connect -> query("SELECT * FROM users WHERE ID_User = '$user'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$surname = $row['surname'];
$sql = "SELECT ID_Device_type, type_device FROM device_type";
$res1 = $connect->query($sql);

$sql2 = "SELECT orders.*, device_type.type_device, status_repair.status_repair 
        FROM orders 
        INNER JOIN device_type ON orders.ID_Device_type = device_type.ID_Device_type 
        INNER JOIN status_repair ON orders.ID_Status_repair = status_repair.ID_Status_repair 
        WHERE ID_User = '$user' 
        ORDER BY ID_Order ASC";
$res2 = $connect->query($sql2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/reset.css">
    <link rel="stylesheet" href="scss/lk.css">
    <title>Личный кабинет</title>
</head>
<body>
<header class="header">
    <div class="header__container">
        <button class="header__burger-btn" id="burger">
            <span></span><span></span><span></span>
        </button>
        <nav class="header__nav">
            <ul class="header__links">
                <li><a href="lk.php"><img src="img/index/Person.png" alt="Личный кабинет"></a></li>
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
            <div class="hero__upper">
                <h1 class="hero__title">Здравствуйте, <br><?php echo $name; ?></h1>
                <a class="hero__exit" href="php/logout.php">Выйти из аккаунта</a>
            </div>
            <div class="hero__wrapper">
                <div class="personal-info">
                    <div class="personal-info__column">
                        <div class="personal-info__item">
                            <p class="personal-info__text"><?php echo $name ?></p>
                            <a class="personal-info__edit" href="#"><img src="img/lk/edit.png" alt=""></a>
                        </div>
                        <div class="personal-info__item">
                            <p class="personal-info__text"><?php echo $surname ?></p>
                            <a class="personal-info__edit" href="#"><img src="img/lk/edit.png" alt=""></a>
                        </div>
                    </div>
                    <img class="personal-info__photo" src="img/lk/1.png" alt="Пользователь">
                </div>
                <div class="orders">
                    <div class="filter-buttons">
                        <button class="active btn" data-category="category1">Готовые заказы</button>
                        <button class="btn" data-category="category2">Заказы в работе</button>
                        <button class="btn" data-category="category3">Отмененные заказы</button>
                    </div>
                    <div class="orders__wrapper">
                    <div class="orders__item category1">
                    <?php mysqli_data_seek($res2, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($res2)) : ?>
                        <?php if ($row['status_repair'] == 'Готов') : ?>
                            <div class="orders__item__flex">
                                <h3 class="orders__id">ID:<?php echo $row['ID_Order'] ?></h3>
                                <div class="orders__item__wrapper">
                                    <p class="orders__type">Тип устройства: <?php echo $row['type_device'] ?></p>
                                    <p class="orders__defect">Неисправность: <?php echo $row['component'] ?></p>
                                    <p class="orders__status">Заказ: <span>Готов</span></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                    </div>
                    <div class="orders__item category2">
                        <?php mysqli_data_seek($res2, 0); ?>
                        <?php while ($row = mysqli_fetch_assoc($res2)) : ?>
                            <?php if ($row['status_repair'] == 'В работе') : ?>
                                <div class="orders__item__flex">
                                    <h3 class="orders__id">ID:<?php echo $row['ID_Order'] ?></h3>
                                    <div class="orders__item__wrapper">
                                        <p class="orders__type">Тип устройства: <?php echo $row['type_device'] ?></p>
                                        <p class="orders__defect">Неисправность: <?php echo $row['component'] ?></p>
                                        <p class="orders__status">Заказ: <span>В работе</span></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                    <div class="orders__item category3">
                        <?php mysqli_data_seek($res2, 0); ?>
                        <?php while ($row = mysqli_fetch_assoc($res2)) : ?>
                            <?php if ($row['status_repair'] == 'Отменен') : ?>
                                <div class="orders__item__flex">
                                    <h3 class="orders__id">ID:<?php echo $row['ID_Order'] ?></h3>
                                    <div class="orders__item__wrapper">
                                        <p class="orders__type">Тип устройства: <?php echo $row['type_device'] ?></p>
                                        <p class="orders__defect">Неисправность: <?php echo $row['component'] ?></p>
                                        <p class="orders__status">Заказ: <span>Отменен</span></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="request">
        <div class="container">
            <div class="popup-bg " id="popup">
                <div class="popup">
                    <img class="close-popup" src="img/exit.png" alt="Выйти">
                    <form action="#">
                        <div class="popup-wrapper">
                            <img src="img/lk/Ok.png" alt="Ура!">
                            <h2 class="popup__title">Ваш ID заказа: <br><span id="order_id"></span></h2>
                            <span class="popup__status">Отслеживайте статус ремонта в личном кабинете</span>
                        </div>
                    </form>
                </div>
            </div>
            <h2 class="request__title">Оставьте заявку на ремонт онлайн</h2>
            <div class="form-wrapper">
                <form action="php/add_form.php" class="request__form" method="post">
                    <select name="list" id="list" class="request__input">
                    <?php
                    // Проверка наличия результатов
                    if ($res1->num_rows > 0) {
                    // Вывод результатов в виде опций
                    while($row = $res1->fetch_assoc()) {
                        echo "<option value='" . $row["ID_Device_type"] . "'>" . $row["type_device"] . "</option>";
                    }
                    } else {
                    echo "0 results";
                    }
                    ?>
                    </select>
                    <input type="text" class="request__input" name="model" placeholder="Модель">
                    <input type="text" class="request__input" name="manufacturer" placeholder="Производитель">
                    <input type="text" class="request__input" name="component" placeholder="Что не работает?(Напишите компонент)">
                    <div class="g-recaptcha" data-sitekey="6LfjoeomAAAAADphwnvVCEVZVR9VxsdNrajLiakC"></div>
                    <input class="request__submit" type="submit" value="Оставить заявку">
                </form>
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
    <script src="js/lk.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/popuplk.js"></script>
</body>
</html>