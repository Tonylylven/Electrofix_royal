<?php
session_start();

require_once 'php/connect.php';

// Проверяем статус администратора
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];

    $query_admin = "SELECT isAdmin FROM users WHERE ID_User = $user_id";
    $result_admin = mysqli_query($connect, $query_admin);

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row_admin = mysqli_fetch_assoc($result_admin);

        if ($row_admin['isAdmin'] == 1) {
            // Пользователь является администратором

            $id = $_GET['id'];

            // Получение данных для выпадающих списков
            $query_status = "SELECT * FROM status_repair";
            $result_status = mysqli_query($connect, $query_status);

            $query_engineer = "SELECT * FROM engineers";
            $result_engineer = mysqli_query($connect, $query_engineer);

            $query_user = "SELECT * FROM users";
            $result_user = mysqli_query($connect, $query_user);

            $query_device_type = "SELECT * FROM device_type";
            $result_device_type = mysqli_query($connect, $query_device_type);

            // Получение данных для текущего заказа
            $query_order = "SELECT * FROM orders WHERE ID_Order = '$id'";
            $result_order = mysqli_query($connect, $query_order);
            $row = mysqli_fetch_assoc($result_order);
        } else {
            // Пользователь не является администратором, перенаправляем на другую страницу
            header('Location: index.php');
            exit;
        }
    } else {
        // Пользователь не найден
        header('Location: index.php');
        exit;
    }

    // Освобождаем ресурсы
    mysqli_free_result($result_admin);
} else {
    // Пользователь не авторизован, перенаправляем на страницу авторизации
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
</head>
<body>
    <h2>Edit Order</h2>

    <form action="php/update_orders.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['ID_Order'] ?>">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <?php
            while ($status_row = mysqli_fetch_assoc($result_status)) {
                $selected = ($status_row['ID_Status_repair'] == $row['ID_Status_repair']) ? "selected" : "";
                echo "<option value='".$status_row['ID_Status_repair']."' $selected>".$status_row['status_repair']."</option>";
            }
            ?>
        </select>

        <label for="engineer">Engineer:</label>
        <select name="engineer" id="engineer">
            <?php
            while ($engineer_row = mysqli_fetch_assoc($result_engineer)) {
                $selected = ($engineer_row['ID_Engineer'] == $row['ID_Engineer']) ? "selected" : "";
                echo "<option value='".$engineer_row['ID_Engineer']."' $selected>".$engineer_row['name']." ".$engineer_row['surname']."</option>";
            }
            ?>
        </select>
        
        <label for="user">User:</label>
        <select name="user" id="user">
            <?php
            while ($user_row = mysqli_fetch_assoc($result_user)) {
                $selected = ($user_row['ID_User'] == $row['ID_User']) ? "selected" : "";
                echo "<option value='".$user_row['ID_User']."' $selected>".$user_row['email']."</option>";
            }
            ?>
        </select>
        
        <label for="device_type">Device Type:</label>
        <select name="device_type" id="device_type">
            <?php
            while ($device_type_row = mysqli_fetch_assoc($result_device_type)) {
                $selected = ($device_type_row['ID_Device_type'] == $row['ID_Device_type']) ? "selected" : "";
                echo "<option value='".$device_type_row['ID_Device_type']."' $selected>".$device_type_row['type_device']."</option>";
            }
            ?>
        </select>
        
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $row['start_date']; ?>">
        
        <label for="completion_date">Completion Date:</label>
        <input type="date" name="completion_date" value="<?php echo $row['completion_date']; ?>">
        
        <label for="component">Component:</label>
        <input type="text" name="component" value="<?php echo $row['component']; ?>">
        
        <label for="warranty">Warranty:</label>
        <input type="date" name="warranty" value="<?php echo $row['warranty']; ?>">
        
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" value="<?php echo $row['manufacturer']; ?>">
        
        <label for="model">Model:</label>
        <input type="text" name="model" value="<?php echo $row['model']; ?>">
        
        <input type="submit" value="Update Order">
    </form>
</body>
</html>