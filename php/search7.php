<?php
include 'access_admin.php';

if(isset($_POST['component'])){
    $component = $_POST['component'];
    $query = "SELECT * FROM orders
                WHERE component = '$component'";
    $result = mysqli_query($connect, $query);
   
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['ID_Device_type'] . "</td>";
        echo "<td>" . $row['model'] . "</td>";
         echo "</tr>";
        }
  }
?>