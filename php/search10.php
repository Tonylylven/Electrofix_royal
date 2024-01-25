<?php
    include 'access_admin.php';
    if(isset($_POST['manufacturer'])){
    $manufacturer = $_POST['manufacturer'];
    $query = "SELECT orders.* FROM orders
            WHERE orders.manufacturer = '$manufacturer'";
    $result = mysqli_query($connect, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['ID_Order'] . "</td>";
        echo "<td>" . $row['ID_User'] . "</td>";
        echo "<td>" . $row['ID_Status_repair'] . "</td>";
        echo "<td>" . $row['ID_Engineer'] . "</td>";
        echo "<td>" . $row['ID_Device_type'] . "</td>";
        echo "<td>" . $row['start_date'] . "</td>";
        echo "<td>" . $row['completion_date'] . "</td>";
        echo "<td>" . $row['component'] . "</td>";
        echo "<td>" . $row['warranty'] . "</td>";
        echo "<td>" . $row['manufacturer'] . "</td>";
        echo "<td>" . $row['model'] . "</td>";
        echo "</tr>";
    }
}

?>
