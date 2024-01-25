<?php
    include 'access_admin.php';
    $engineer = $_POST['engineer']; // Получите значение выбранного инженера из POST-запроса
    $query = "SELECT * FROM orders
    WHERE ID_engineer = '$engineer'";
    $result = mysqli_query($connect, $query);

    while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['ID_Device_type'] . "</td>";
    echo "<td>" . $row['model'] . "</td>";
    echo "</tr>";
    }
?>