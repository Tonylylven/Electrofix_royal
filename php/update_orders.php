<?php
include 'access_admin.php';

$id = $_POST['id'];

$status = $_POST['status'];
$engineer = $_POST['engineer'];
$user = $_POST['user'];
$device_type = $_POST['device_type'];
$start_date = $_POST['start_date'];
$completion_date = $_POST['completion_date'];
$component = $_POST['component'];
$warranty = $_POST['warranty'];
$manufacturer = $_POST['manufacturer'];
$model = $_POST['model'];

$query = "UPDATE orders
          SET ID_Status_repair = '$status', ID_Engineer = '$engineer', ID_User = '$user', ID_Device_type = '$device_type',
              start_date = '$start_date', completion_date = '$completion_date', component = '$component', warranty = '$warranty',
              manufacturer = '$manufacturer', model = '$model'
          WHERE ID_Order = '$id'";

if (mysqli_query($connect, $query)) {
    // Успешно обновлены данные заказа
    header("Location: ../admin.php"); // Перенаправление на admin.php
    exit;
} else {
    // Произошла ошибка при обновлении заказа
    echo "Error updating order: " . mysqli_error($connect);
}

?>