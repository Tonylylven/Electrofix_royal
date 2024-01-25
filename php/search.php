<?php
header('Content-Type: application/json');
require_once 'connect.php';

$id = $_POST['id'];
$query = "SELECT orders.*, status_repair.status_repair FROM orders INNER JOIN status_repair ON orders.ID_Status_repair = status_repair.ID_Status_repair WHERE ID_Order = $id";
$result = mysqli_query($connect, $query);

if($result) {
  if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    $response = array(
      'status' => 'success',
      'manufacturer' => $row['manufacturer'],
      'model' => $row['model'],
      'status_repair' => $row['status_repair'],
      'component' => $row['component'],
      'start_date' => $row['start_date']
    );
    
    echo json_encode($response);
  } else {
    $response = array('status' => 'error');
    echo json_encode($response);
  }
} else {
  $response = array('status' => 'error');
  echo json_encode($response);
}

mysqli_close($connect);
?>