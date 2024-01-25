<?php
    include 'access_admin.php';
    if(isset($_POST['email'])){
      $email = $_POST['email'];
      $query = "SELECT orders.* FROM orders
              INNER JOIN users ON orders.ID_User = users.ID_User
              WHERE orders.ID_Status_repair = '2' AND users.email = '{$email}'";
      $result = mysqli_query($connect, $query);
     
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['ID_Order'] . "</td>";
        echo "<td>" . $row['ID_User'] . "</td>";
        echo "<td>" . $row['ID_Status_repair'] . "</td>";
        echo "<td>". $row['ID_Device_type'] . "</td>";
        echo "<td>". $row['model'] . "</td>";
        echo "</tr>";
      }
    }
  ?>