<?php
session_start();
require_once 'php/connect.php';
// Проверяем, был ли пользователь авторизован
if(isset($_SESSION['user'])) {
    // Получение информации о пользователе из базы данных
    $sql = "SELECT isAdmin FROM users WHERE ID_User = ".$_SESSION['user'];
    $result = mysqli_query($connect, $sql);
    
    if($result && mysqli_num_rows($result) == 1) {
        // получаем данные пользователя
        $row = mysqli_fetch_assoc($result);
        
        // Проверка значения столбца isAdmin
        if($row['isAdmin'] == 1) {
            // Пользователь является администратором - продолжаем выполнение кода для админки
            // ...
        } else {
            // Пользователь не является администратором - перенаправляем на другую страницу или выводим сообщение об ошибке
            echo "У вас нет доступа к этой странице.";
            mysqli_close($connect);
            exit;
        }
    } else {
        // Ошибка при выполнении запроса или пользователь не найден - перенаправляем на другую страницу или выводим сообщение об ошибке
        echo "Произошла ошибка. Пожалуйста, войдите в систему.";
        mysqli_close($connect);
        exit;
    }
} else {
    // Пользователь не авторизован - перенаправляем на страницу входа или выводим сообщение об ошибке
    echo "Войдите в свою учетную запись для доступа к этой странице.";
    mysqli_close($connect);
    exit;
}
$user = $_SESSION['user'];
$result = $connect -> query("SELECT * FROM Users WHERE ID_User = '$user'");
$row = mysqli_fetch_assoc($result);
$admin = $row['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="scss/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/admin.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="menu">
            <?php echo "Привет, <br> $admin" ?>
            <div class="menu-item" onclick="openTab('device_types')">Тип девайса</div>
            <div class="menu-item" onclick="openTab('technics')">Техники</div>
            <div class="menu-item" onclick="openTab('orders')">Заказы</div>
            <div class="menu-item" onclick="openTab('repair_status')">Статус ремонта</div>
            <div class="menu-item" onclick="openTab('registered_users')">Зарегистрированные пользователи</div>
            <div class="menu-item" onclick="openTab('unregistered_users')">Незарегистрированные пользователи</div>
            <div class="menu-item" onclick="openTab('requests')">Запросы</div>
            <a class="logout-button" href="php/logout.php">Выход</a>
        </div>
    </div>
    
    <div class="content">
        <div id="device_types" class="tab-content">
            <h2>Тип девайса</h2>
            <!-- Здесь будет содержимое таблицы "Тип девайса" -->
            <table>
                <tr>
                    <th>ID_Device_type</th>
                    <th>type_device</th>
                </tr>
                <?php

                $devices = mysqli_query($connect, "SELECT * FROM `device_type`");

                $devices = mysqli_fetch_all($devices);
                foreach ($devices as $device) {
                    ?>
                        <tr>
                            <td><?= $device[0] ?></td>
                            <td><?= $device[1] ?></td>
                            <td><a href="update_td.php?id=<?= $device[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_type_device.php?id=<?= $device[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте новый тип девайса</h3>
            <form action="php/create_type_device.php" method="post">
                <p>type_device</p>
                <input type="text" name="type_device" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="technics" class="tab-content">
            <h2>Техники</h2>
            <!-- Здесь будет содержимое таблицы "Техники" -->
            <table>
                <tr>
                    <th>ID_Engineer</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                </tr>
                <?php

                $engineers = mysqli_query($connect, "SELECT * FROM `Engineers`");

                $engineers = mysqli_fetch_all($engineers);
                foreach ($engineers as $engineer) {
                    ?>
                        <tr>
                            <td><?= $engineer[0] ?></td>
                            <td><?= $engineer[1] ?></td>
                            <td><?= $engineer[2] ?></td>
                            <td><a href="update_eng.php?id=<?= $engineer[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_engineers.php?id=<?= $engineer[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте нового техника</h3>
            <form action="php/create_engineers.php" method="post">
                <p>Имя</p>
                <input type="text" name="name" required>
                <p>Фамилия</p>
                <input type="text" name="surname" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="orders" class="tab-content">
            <h2>Заказы</h2>
            <!-- Create -->
        <form action="php/create_orders.php" method="POST">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <!-- Options for status_repair dropdown -->
                <?php
                // Connect to the database and fetch the status_repair values
                $query = "SELECT * FROM status_repair";
                $result = mysqli_query($connect, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['ID_Status_repair']."'>".$row['status_repair']."</option>";
                }
                ?>
            </select>
        <br>
        <label for="engineer">Engineer:</label>
        <select name="engineer" id="engineer">
            <!-- Options for engineers dropdown -->
            <?php
            // Connect to the database and fetch the engineers values
            $query = "SELECT * FROM engineers";
            $result = mysqli_query($connect, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['ID_Engineer']."'>".$row['name']." ".$row['surname']."</option>";
            }
            ?>
        </select>
        <br>
        <label for="user">User:</label>
        <select name="user" id="user">
            <!-- Options for users dropdown -->
            <?php
            // Connect to the database and fetch the users values
            $query = "SELECT * FROM users";
            $result = mysqli_query($connect, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['ID_User']."'>".$row['email']."</option>";
            }
            ?>
        </select>
        <br>
        <label for="device_type">Device Type:</label>
        <select name="device_type" id="device_type">
            <!-- Options for device_type dropdown -->
            <?php
            // Connect to the database and fetch the device_type values
            $query = "SELECT * FROM device_type";
            $result = mysqli_query($connect, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['ID_Device_type']."'>".$row['type_device']."</option>";
            }
            ?>
        </select> <br>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
            <br>
            <label for="completion_date">Completion Date:</label>
            <input type="date" name="completion_date" id="completion_date" required>
            <br>
            <label for="component">Component:</label>
            <input type="text" name="component" id="component" required>
            <br>
            <label for="warranty">Warranty:</label>
            <input type="date" name="warranty" id="warranty" required>
            <br>
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" name="manufacturer" id="manufacturer" required>
            <br>
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" required>
            <br>
            <input type="submit" value="Create Order">
        </form>
    
    <!-- Read -->
        <table>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Engineer</th>
                <th>User</th>
                <th>Device Type</th>
                <th>Start Date</th>
                <th>Completion Date</th>
                <th>Component</th>
                <th>Warranty</th>
                <th>Manufacturer</th>
                <th>Model</th>
                <th>Actions</th>
            </tr>

        <?php
        // Connect to the database and fetch the orders
        $query = "SELECT orders.ID_Order, status_repair.status_repair, engineers.name AS engineer_name, engineers.surname AS engineer_surname, users.email, device_type.type_device, orders.start_date, 
        orders.completion_date, orders.component, orders.warranty, orders.manufacturer, orders.model
        FROM orders
        LEFT JOIN status_repair ON orders.ID_Status_repair = status_repair.ID_Status_repair
        LEFT JOIN engineers ON orders.ID_Engineer = engineers.ID_Engineer
        LEFT JOIN users ON orders.ID_User = users.ID_User
        LEFT JOIN device_type ON orders.ID_Device_type = device_type.ID_Device_type";
        $result = mysqli_query($connect, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['ID_Order']."</td>";
            echo "<td>".$row['status_repair']."</td>";
            echo "<td>".$row['engineer_name']." ".$row['engineer_surname']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['type_device']."</td>";
            echo "<td>".$row['start_date']."</td>";
            echo "<td>".$row['completion_date']."</td>";
            echo "<td>".$row['component']."</td>";
            echo "<td>".$row['warranty']."</td>";
            echo "<td>".$row['manufacturer']."</td>";
            echo "<td>".$row['model']."</td>";
            echo "<td>";
            echo "<a href='update_ord.php?id=".$row['ID_Order']."'>Update</a> &nbsp;";
            echo "<a href='php/delete_orders.php'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </table>
        </div>
        <div id="repair_status" class="tab-content">
            <h2>Статус ремонта</h2>
            <!-- Здесь будет содержимое таблицы "Статус ремонта" -->
            <table>
                <tr>
                    <th>ID_Status_repair</th>
                    <th>status_repair</th>
                </tr>
                <?php

                $status_repair = mysqli_query($connect, "SELECT * FROM `status_repair`");

                $status_repair = mysqli_fetch_all($status_repair);
                foreach ($status_repair as $status) {
                    ?>
                        <tr>
                            <td><?= $status[0] ?></td>
                            <td><?= $status[1] ?></td>
                            <td><a href="update_status.php?id=<?= $status[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_status.php?id=<?= $status[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте новый статус заказа</h3>
            <form action="php/create_status.php" method="post">
                <p>status_repair</p>
                <input type="text" name="status_repair" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="registered_users" class="tab-content">
            <h2>Зарегистрированные пользователи</h2>
            <!-- Здесь будет содержимое таблицы "Зарегистрированные пользователи" -->
            <table>
                <tr>
                    <th>ID_User</th>
                    <th>Почта</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Пароль</th>
                    <th>Админ</th>
                </tr>
                <?php

                $users = mysqli_query($connect, "SELECT * FROM `users`");

                $users = mysqli_fetch_all($users);
                foreach ($users as $user) {
                    ?>
                        <tr>
                            <td><?= $user[0] ?></td>
                            <td><?= $user[1] ?></td>
                            <td><?= $user[2] ?></td>
                            <td><?= $user[3] ?></td>
                            <td><?= $user[4] ?></td>
                            <td><?= $user[5] ?></td>
                            <td><a href="update_reg.php?id=<?= $user[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_users.php?id=<?= $user[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте нового зарегистрированного пользователя</h3>
            <form action="php/create_users.php" method="post">
                <p>Почта</p>
                <input type="mail" name="email" required>
                <p>Имя</p>
                <input type="text" name="name" required>
                <p>Фамилия</p>
                <input type="text" name="surname" required>
                <p>Пароль</p>
                <input type="password" name="password" required>
                <p>Админ</p>
                <input type="number" name="isAdmin" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="unregistered_users" class="tab-content">
            <h2>Незарегистрированные пользователи</h2>
            <!-- Здесь будет содержимое таблицы "Незарегистрированные пользователи" -->
            <table>
                <tr>
                    <th>ID_User_2</th>
                    <th>Телефон</th>
                    <th>Имя</th>
                    <th>Статус звонка</th>
                    <th>Дата и время</th>
                </tr>
                <?php

                $users_2 = mysqli_query($connect, "SELECT * FROM `users_2`");

                $users_2 = mysqli_fetch_all($users_2);
                foreach ($users_2 as $user_2) {
                    ?>
                        <tr>
                            <td><?= $user_2[0] ?></td>
                            <td><?= $user_2[1] ?></td>
                            <td><?= $user_2[2] ?></td>
                            <td><?= $user_2[3] ?></td>
                            <td><?= $user_2[4] ?></td>
                            <td><a href="update_user_2.php?id=<?= $user_2[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_users_2.php?id=<?= $user_2[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте нового незарегистрированного пользователя</h3>
            <form action="php/create_users_2.php" method="post">
                <p>Телефон</p>
                <input type="tel" name="telephone" required>
                <p>Имя</p>
                <input type="text" name="name" required>
                <p>Статус звонка</p>
                <input type="number" name="status_call" required>
                <p>Дата и время</p>
                <input type="datetime" name="curr_date" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="requests" class="tab-content">
            <h2>Запросы</h2>
            <!-- Здесь будет содержимое таблицы "Запросы" -->
            <!-- Запрос 1 -->
            <h2>Получить список всех устройств, находящихся в ремонте с данными заказчика.</h2>
            <form id="searchForm1" method="POST">
                <input type="text" name="email-1" id="email" placeholder="Напишите email заказчика" required>
            </form>

            <table>
            <thead>
            <tr>
                <th>ID_Order</th>
                <th>ID_User</th>
                <th>ID_Status_repair</th>
                <th>ID_Device_type</th>
                <th>Model</th>
            </tr>
            </thead>
            <tbody class="tbody-1">
            </tbody>
            </table>

            <!-- Запрос 2 -->
            <h2>Получить список всех ремонтных заказов, выполненных определенным техником.</h2>
            <form id="searchForm2" method="POST">
                <select name="engineer" id="engineer-request">
                    <!-- Options for engineers dropdown -->
                    <?php
                    // Connect to the database and fetch the engineers values
                    $query = "SELECT * FROM engineers";
                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['ID_Engineer']."'>".$row['name']." ".$row['surname']."</option>";
                    }
                    ?>
                </select>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID_Order</th>
                        <th>ID_User</th>
                        <th>ID_Status_repair</th>
                        <th>ID_Engineer</th>
                        <th>ID_Device_type</th>
                        <th>Start_date</th>
                        <th>Completion_date</th>
                        <th>Component</th>
                        <th>Warranty</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                    </tr>
                </thead>
                <tbody class="tbody-2"></tbody>
            </table>
            
            <!-- Запрос 3 -->
            <h2>Получить список всех устройств, у которых гарантия истекла.</h2>
            <table>
            <thead>
                <tr>
                    <th>ID_Device_type</th>
                    <th>Model</th>
                    <th>Warranty</th>
                </tr>
            </thead>
            <tbody class="tbody-3">
            <?php
            $query = "SELECT * FROM orders WHERE warranty < CURDATE()";
            $result = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ID_Device_type'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['warranty'] . "</td>";
            echo "</tr>";
            }
            ?>
            </tbody>
            </table>
            <!-- 4 Запрос -->
            <h2>Получить список всех клиентов, у которых есть активные ремонтные заказы.</h2>
            <table>
            <thead>
                <tr>
                    <th>ID_User</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $query = "SELECT DISTINCT users.* FROM users
                        INNER JOIN orders ON orders.ID_User = users.ID_User
                        WHERE orders.ID_Status_repair = '2'";
                $result = mysqli_query($connect, $query);
            
                while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID_User'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
                }
            ?>
            </tbody>
            </table>

            <!-- 5 Запрос -->
            <h2>Получить список всех устройств, которые были ремонтированы определенным техником.</h2>
            <form id="searchForm5" method="POST">
                <select name="engineer" id="engineer-request-2">
                    <!-- Options for engineers dropdown -->
                    <?php
                    // Connect to the database and fetch the engineers values
                    $query = "SELECT * FROM engineers";
                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['ID_Engineer']."'>".$row['name']." ".$row['surname']."</option>";
                    }
                    ?>
                </select>
            </form>
            <table>
            <thead>
                <tr>
                    <th>ID_Device_type</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody class="tbody-5"> </tbody>
            </table>
            <!-- Запрос 6 -->
            <h2>Получить список всех ремонтных заказов, у которых дата завершения ремонта попадает в заданный временной интервал.</h2>
            <form id="searchForm6" method="POST">
                <input type="date" name="start_date" id="start-date" required>
                <input type="date" name="end_date" id="end-date" required>
                <button type="submit">Отправить</button>
            </form>
            <table>
            <thead>
                <tr>
                        <th>ID_Order</th>
                        <th>ID_User</th>
                        <th>ID_Status_repair</th>
                        <th>ID_Engineer</th>
                        <th>ID_Device_type</th>
                        <th>Start_date</th>
                        <th>Completion_date</th>
                        <th>Component</th>
                        <th>Warranty</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                </tr>
            </thead>
            <tbody class="tbody-6"></tbody>
            </table>
            <!-- Запрос 7 -->
            <h2>Получить список всех устройств, у которых неисправность связана с определенным компонентом.</h2>
            <form id="searchForm7" method="POST">
                <input type="text" name="component" id="component1" placeholder="Компонент" required>
            </form>
            <table>
            <thead>
                <tr>
                    <th>ID_Device_type</th>
                    <th>model</th>
                </tr>
            </thead>
            <tbody class="tbody-7"></tbody>
            </table>
            <!-- Запрос 8 -->
            <h2>Получить список всех устройств, сгруппированных по типу и указанием общего количества устройств каждого типа.</h2>
            <table>
            <thead>
                <tr>
                    <th>Type_Device</th>
                    <th>Total_devices</th>
                </tr>
            </thead>
            <tbody class="tbody-8">
            <?php
                $query = "SELECT device_type.type_device, COUNT(*) AS total_devices
                        FROM device_type
                        INNER JOIN orders ON orders.ID_Device_type = device_type.ID_Device_type
                        GROUP BY device_type.ID_Device_type";
                $result = mysqli_query($connect, $query);
            
                while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['type_device'] . "</td>";
                echo "<td>" . $row['total_devices'] . "</td>";
                echo "</tr>";
                }
            ?>
            </tbody>
            </table>
            <!-- Запрос 9 -->
            <h2>Получить список всех ремонтных заказов, сгруппированных по статусу и указанием количества заказов для каждого статуса.</h2>
            <table>
            <thead>
                <tr>
                    <th>Status_repair</th>
                    <th>Total_orders</th>
                </tr>
            </thead>
            <tbody class="tbody-9">
                <?php
                    $query = "SELECT status_repair.status_repair, COUNT(*) AS total_orders
                            FROM status_repair
                            INNER JOIN orders ON orders.ID_Status_repair = status_repair.ID_Status_repair
                            GROUP BY status_repair.ID_Status_repair";
                    $result = mysqli_query($connect, $query);
                
                    while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['status_repair'] . "</td>";
                    echo "<td>" . $row['total_orders'] . "</td>";
                    echo "</tr>";
                    }
                ?>
            </tbody>
            </table>
            <!-- Запрос 10 -->
            <h2>Получить список всех ремонтных заказов, у которых неисправность связана с определенным производителем устройства.</h2>
            <form id="searchForm10" method="POST">
                <input type="text" name="manufacturer" id="manufacturer1" placeholder="Производитель" required>
            </form>
            <table>
            <thead>
                <tr>
                    <th>ID_Order</th>
                    <th>ID_User</th>
                    <th>ID_Status_repair</th>
                    <th>ID_Engineer</th>
                    <th>ID_Device_type</th>
                    <th>Start_date</th>
                    <th>Completion_date</th>
                    <th>Component</th>
                    <th>Warranty</th>
                    <th>Manufacturer</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody class="tbody-10"></tbody>
            </table>
        </div>
    </div>
</body>
</html>
