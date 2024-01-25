<?php
session_start();
require_once 'connect.php';
// Получение данных из формы
$id = $_SESSION['user'];
$type = $_POST['list'];
$model = $_POST['model'];
$manufacturer = $_POST['manufacturer'];
$component = $_POST['component'];
$engineer = 'NULL';
// $engineers_query = "SELECT * FROM engineers ORDER BY RAND() LIMIT 2"; // выбираем двух случайных инженеров
// $engineers_result = $connect->query($engineers_query);
// $engineers_array = array(); // создаем пустой массив для инженеров
// if ($engineers_result->num_rows > 0) {
//   while($row = $engineers_result->fetch_assoc()) {
//     array_push($engineers_array, $row["ID_Engineer"]); // добавляем ID инженеров в массив
//   }
// }
// $random_index = array_rand($engineers_array); // выбираем случайный индекс из массива инженеров
// $engineer = $engineers_array[$random_index]; // получаем ID инженера для данного заказа
$start_date = date("Y-m-d"); // дата начала ремонта равна текущей дате
// Создание запроса в базу данных
$sql = "INSERT INTO `orders` (`ID_Order`, `ID_Status_repair`, `ID_Engineer`, `ID_User`, `ID_Device_type`, `start_date`, `completion_date`, `component`, `warranty`, `manufacturer`, `model`) 
VALUES (NULL, '2', $engineer, '$id', '$type', '$start_date', NULL, '$component', NULL, '$manufacturer', '$model')";

// Проверка успешности выполнения запроса
if ($connect->query($sql) === TRUE) {
  $last_id = $connect->insert_id; // получаем ID последнего вставленного заказа
  echo $last_id; // возвращаем ID заказа
} else {
  echo "Error: " . $sql . "<br>" . $connect->error;
}

// Закрытие соединения
$connect->close();

?>