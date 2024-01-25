<?php
include 'access_admin.php';
if(isset($_POST['start_date']) && isset($_POST['end_date'])){
   $start_date = $_POST['start_date'];
   $end_date = $_POST['end_date'];

   // Подключение к базе данных

   // Выполнение SQL запроса
   $query = "SELECT * FROM orders WHERE completion_date BETWEEN '$start_date' AND '$end_date'";
   $result = mysqli_query($connect, $query);

   // Форматирование результата
   if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
         echo "<tr>";
         echo "<td>".$row['ID_Order']."</td>";
         echo "<td>".$row['ID_User']."</td>";
         echo "<td>".$row['ID_Status_repair']."</td>";
         echo "<td>".$row['ID_Engineer']."</td>";
         echo "<td>".$row['ID_Device_type']."</td>";
         echo "<td>".$row['start_date']."</td>";
         echo "<td>".$row['completion_date']."</td>";
         echo "<td>".$row['component']."</td>";
         echo "<td>".$row['warranty']."</td>";
         echo "<td>".$row['manufacturer']."</td>";
         echo "<td>".$row['model']."</td>";
         echo "</tr>";
      }
   } else {
      echo "<tr><td colspan='11'>Нет результатов</td></tr>";
   }

   // Закрытие соединения с базой данных
}
?>